<?php

namespace App\Http\Controllers;

use App\Models\PresensiSession;
use App\Models\PresensiRecord;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Siswa;
use Illuminate\Support\Facades\View;
use App\Exports\ArrayExport;

class AdminPresensiController extends Controller
{
    public function index()
    {
        $totalSessions = PresensiSession::count();
        $activeSessions = PresensiSession::active()->count();
        $totalRecords = PresensiRecord::count();
        $hadirToday = PresensiRecord::whereDate('created_at', today())
            ->whereIn('status', ['hadir', 'terlambat'])
            ->count();

        // Ambil data statistik lengkap untuk dashboard (jika diperlukan)
        $request = new Request(); // Buat request kosong untuk getGeneralStats
        $generalStats = $this->getGeneralStats($request); 

        $stats = [
            'total_sessions' => $totalSessions,
            'active_sessions' => $activeSessions,
            'total_records' => $totalRecords,
            'hadir_today' => $hadirToday,
            // Anda bisa tambahkan data dari generalStats jika ingin menampilkannya di dashboard
            // 'hadir' => $generalStats['hadir'],
            // 'terlambat' => $generalStats['terlambat'],
            // 'sakit' => $generalStats['sakit'],
            // 'izin' => $generalStats['izin'],
            // 'alpa' => $generalStats['alpa'],
        ];


        return view('admin.presensi.index', compact('stats'));
    }

    public function exportLaporanExcel(Request $request)
    {
        $records = $this->getFilteredRecords($request);

        $exportData = $records->map(function ($record, $index) {
            return [
                'No' => $index + 1,
                'Nama Siswa' => $record->siswa->username ?? '-',
                'Kelas' => $record->presensiSession->kelas->nama_kelas ?? '-',
                'Mapel' => $record->presensiSession->mapel->nama_mapel ?? '-',
                'Guru' => $record->presensiSession->guru->username ?? '-',
                'Tanggal' => \Carbon\Carbon::parse($record->presensiSession->tanggal)->format('d-m-Y'),
                // Menampilkan status 'Alpa' jika statusnya 'tidak_hadir'
                'Status' => $record->status == 'tidak_hadir' ? 'Alpa' : ucfirst($record->status),
            ];
        });

        // Menggunakan ArrayExport yang sudah ada
        return Excel::download(new ArrayExport($exportData->toArray(), [
            'No', 'Nama Siswa', 'Kelas', 'Mapel', 'Guru', 'Tanggal', 'Status' // Pastikan header sesuai
        ]), 'laporan_presensi.xlsx');
    }
    public function exportLaporanPDF(Request $request)
    {
        $records = $this->getFilteredRecords($request);

        $data = [
            'records' => $records,
        ];

        $pdf = Pdf::loadView('admin.presensi.exportpresensilaporan', $data)
            ->setPaper('A4', 'landscape');

        return $pdf->download('laporan_presensi.pdf');
    }

    private function getFilteredRecords($request)
    {
        $query = PresensiRecord::with(['siswa', 'presensiSession.kelas', 'presensiSession.mapel', 'presensiSession.guru']);

        if ($request->filled('kelas_id')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->filled('mapel_id')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->where('mapel_id', $request->mapel_id);
            });
        }

        if ($request->filled('guru_id')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->where('guru_id', $request->guru_id);
            });
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->whereDate('tanggal', '>=', $request->tanggal_mulai);
            });
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->whereDate('tanggal', '<=', $request->tanggal_selesai);
            });
        }

        return $query->get();
    }

    public function sessions(Request $request)
    {
        $query = PresensiSession::with(['kelas', 'mapel', 'guru', 'semester']);

        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter berdasarkan guru
        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }
        $mapels = Mapel::all(); // ✅ Tambahan
            $query->when($request->mapel_id, fn($q) => $q->where('mapel_id', $request->mapel_id)); // ✅ Tambahan
        $sessions = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->paginate(20);

        $kelas = Kelas::all();
        
        $gurus = User::where('role', 'guru')->get();

        return view('admin.presensi.sessions', compact('sessions', 'kelas', 'gurus', 'mapels'));
    }



    public function closeSession($id)
    {
        $session = PresensiSession::find($id); // Menggunakan namespace global

        if (!$session) {
            return response()->json(['message' => 'Sesi tidak ditemukan'], 404);
        }

        $session->closeSession(); // Panggil method dari model
        return redirect()
            ->route('admin.presensi.sessions')
            ->with('success', 'Sesi berhasil ditutup');

    }



    public function exportDetail($id, $format)
    {
        $session = PresensiSession::with(['guru', 'mapel', 'kelas', 'presensiRecords.siswa'])->findOrFail($id); // Menggunakan namespace global

        if ($format === 'excel') {
            return Excel::download(new \App\Exports\PresensiDetailExport($session), 'Presensi_' . $session->kelas->nama_kelas . '.xlsx');
        }

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.presensi.export-detail-pdf', compact('session'))
                    ->setPaper('a4', 'portrait');
            return $pdf->download('Presensi_' . $session->kelas->nama_kelas . '.pdf');
        }

        return back()->with('error', 'Format tidak dikenal');
    }

    public function getActiveSessions()
    {
        try {
            $today = now()->format('Y-m-d');

            // Ambil sesi yang tanggal hari ini DAN masih aktif serta belum ditutup
            $sessions = PresensiSession::with(['guru', 'mapel', 'kelas']) // Menggunakan namespace global
                ->whereDate('tanggal', $today)
                ->where('is_active', true)
                ->where('is_closed', false)
                ->get()
                ->map(function ($session) {
                    return [
                        'id' => $session->id,
                        'kelas' => $session->kelas,
                        'mapel' => $session->mapel,
                        'guru' => $session->guru,
                        'jam_mulai_formatted' => \Carbon\Carbon::parse($session->jam_mulai)->format('H:i'),
                        'mode' => $session->mode,
                    ];
                });

            return response()->json($sessions);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function showSession($id)
    {
        $session = PresensiSession::with(['guru', 'mapel', 'kelas', 'presensiRecords.siswa'])->find($id); // Menggunakan namespace global

        if (!$session) {
            abort(404, 'Sesi tidak ditemukan');
        }

        return view('admin.presensi.detail', compact('session'));
    }



   public function reports(Request $request)
    {
        $query = PresensiRecord::with([
            'presensiSession.kelas',
            'presensiSession.mapel',
            'presensiSession.guru',
            'siswa'
        ]);

        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        // 🔹 Filter berdasarkan mapel
        if ($request->filled('mapel_id')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->where('mapel_id', $request->mapel_id);
            });
        }

        // 🔹 Filter berdasarkan guru
        if ($request->filled('guru_id')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->where('guru_id', $request->guru_id);
            });
        }

        // Filter tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->whereDate('tanggal', '>=', $request->tanggal_mulai);
            });
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->whereDate('tanggal', '<=', $request->tanggal_selesai);
            });
        }

        $records = $query->orderBy('created_at', 'desc')->paginate(20);

        // Ambil data untuk dropdown
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $gurus = User::where('role', 'guru')->get();

        // Statistik
        $stats = $this->getGeneralStats($request); // Memanggil method yang sudah diperbaiki

        return view('admin.presensi.reports', compact('records', 'kelas', 'mapels', 'gurus', 'stats'));
    }


    public function kelasReport($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);

        $sessions = PresensiSession::with(['mapel', 'guru', 'presensiRecords']) // Menggunakan namespace global
            ->where('kelas_id', $kelasId)
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        $stats = $this->getKelasStats($kelasId);

        return view('admin.presensi.kelas-report', compact('kelas', 'sessions', 'stats'));
    }

    public function siswaReport($siswaId)
    {
        $siswa = User::findOrFail($siswaId);

        $records = PresensiRecord::with(['presensiSession.mapel', 'presensiSession.guru'])
            ->where('siswa_id', $siswaId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = $this->getSiswaStats($siswaId);

        return view('admin.presensi.siswa-report', compact('siswa', 'records', 'stats'));
    }

    public function exportExcel(Request $request)
    {
        // Implementasi export Excel (Sudah diperbaiki di exportLaporanExcel)
        return $this->exportLaporanExcel($request);
    }

    // [--- METHOD getGeneralStats DIPERBARUI ---]
    private function getGeneralStats($request)
    {
        $query = PresensiRecord::query();

        // --- Filter (Kode filter tidak diubah) ---
        if ($request->filled('kelas_id')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }
        if ($request->filled('mapel_id')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->where('mapel_id', $request->mapel_id);
            });
        }
        if ($request->filled('guru_id')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->where('guru_id', $request->guru_id);
            });
        }
        if ($request->filled('tanggal_mulai')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->whereDate('tanggal', '>=', $request->tanggal_mulai);
            });
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->whereDate('tanggal', '<=', $request->tanggal_selesai);
            });
        }
        // --- Akhir Filter ---


        // [PERBAIKAN] Hitung semua status
        $total = (clone $query)->count(); // Gunakan clone agar query asli tidak terpengaruh
        $hadir = (clone $query)->where('status', 'hadir')->count();
        $terlambat = (clone $query)->where('status', 'terlambat')->count();
        $sakit = (clone $query)->where('status', 'sakit')->count(); // <-- Tambahkan ini
        $izin = (clone $query)->where('status', 'izin')->count();   // <-- Tambahkan ini
        $alpa = (clone $query)->where('status', 'tidak_hadir')->count(); // Ganti nama variabel

        return [
            'total' => $total,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'sakit' => $sakit,       // <-- Kembalikan data sakit
            'izin' => $izin,         // <-- Kembalikan data izin
            'alpa' => $alpa,         // <-- Ganti nama key menjadi 'alpa'
            'persentase_hadir' => $total > 0 ? round(($hadir + $terlambat) / $total * 100, 2) : 0,
            // Hapus 'tidak_hadir' jika sudah diganti 'alpa'
            // 'tidak_hadir' => $tidakHadir, // <-- Kunci ini tidak diperlukan lagi
        ];
    }
    // [--- AKHIR PERBAIKAN getGeneralStats ---]


    private function getKelasStats($kelasId)
    {
        $totalSessions = PresensiSession::where('kelas_id', $kelasId)->count(); // Menggunakan namespace global
        $totalRecords = PresensiRecord::whereHas('presensiSession', function ($q) use ($kelasId) {
            $q->where('kelas_id', $kelasId);
        })->count();

        $hadir = PresensiRecord::whereHas('presensiSession', function ($q) use ($kelasId) {
            $q->where('kelas_id', $kelasId);
        })->whereIn('status', ['hadir', 'terlambat'])->count();

        return [
            'total_sessions' => $totalSessions,
            'total_records' => $totalRecords,
            'hadir' => $hadir,
            'persentase_hadir' => $totalRecords > 0 ? round($hadir / $totalRecords * 100, 2) : 0,
        ];
    }

    private function getSiswaStats($siswaId)
    {
        $totalRecords = PresensiRecord::where('siswa_id', $siswaId)->count();
        $hadir = PresensiRecord::where('siswa_id', $siswaId)->where('status', 'hadir')->count();
        $terlambat = PresensiRecord::where('siswa_id', $siswaId)->where('status', 'terlambat')->count();
        $alpa = PresensiRecord::where('siswa_id', $siswaId)->where('status', 'tidak_hadir')->count(); // Ganti nama
        $sakit = PresensiRecord::where('siswa_id', $siswaId)->where('status', 'sakit')->count(); // Tambah
        $izin = PresensiRecord::where('siswa_id', $siswaId)->where('status', 'izin')->count(); // Tambah


        return [
            'total_records' => $totalRecords,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'sakit' => $sakit, // Kembalikan
            'izin' => $izin, // Kembalikan
            'alpa' => $alpa, // Ganti nama key
            // 'tidak_hadir' => $tidakHadir, // Hapus
            'persentase_hadir' => $totalRecords > 0 ? round(($hadir + $terlambat) / $totalRecords * 100, 2) : 0,
        ];
    }
}