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

        $stats = [
            'total_sessions' => $totalSessions,
            'active_sessions' => $activeSessions,
            'total_records' => $totalRecords,
            'hadir_today' => $hadirToday,
        ];

        return view('admin.presensi.index', compact('stats'));
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

        $sessions = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->paginate(20);

        $kelas = Kelas::all();
        $gurus = User::where('role', 'guru')->get();

        return view('admin.presensi.sessions', compact('sessions', 'kelas', 'gurus'));
    }



public function closeSession($id)
{
    $session = \App\Models\PresensiSession::find($id);

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
    $session = \App\Models\PresensiSession::with(['guru', 'mapel', 'kelas', 'presensiRecords.siswa'])->findOrFail($id);

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
        $sessions = PresensiSession::with(['guru', 'mapel', 'kelas'])
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
    $session = \App\Models\PresensiSession::with(['guru', 'mapel', 'kelas', 'presensiRecords.siswa'])->find($id);

    if (!$session) {
        abort(404, 'Sesi tidak ditemukan');
    }

    return view('admin.presensi.detail', compact('session'));
}



    public function reports(Request $request)
    {
        $query = PresensiRecord::with(['presensiSession.kelas', 'presensiSession.mapel', 'presensiSession.guru', 'siswa']);

        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        // Filter berdasarkan tanggal
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

        $kelas = Kelas::all();

        // Statistik umum
        $stats = $this->getGeneralStats($request);

        return view('admin.presensi.reports', compact('records', 'kelas', 'stats'));
    }

    public function kelasReport($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);

        $sessions = PresensiSession::with(['mapel', 'guru', 'presensiRecords'])
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
        // Implementasi export Excel
        // Bisa menggunakan Laravel Excel package
        return response()->json(['message' => 'Export Excel akan diimplementasi']);
    }

    private function getGeneralStats($request)
    {
        $query = PresensiRecord::query();

        if ($request->filled('kelas_id')) {
            $query->whereHas('presensiSession', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
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

        $total = $query->count();
        $hadir = $query->clone()->where('status', 'hadir')->count();
        $terlambat = $query->clone()->where('status', 'terlambat')->count();
        $tidakHadir = $query->clone()->where('status', 'tidak_hadir')->count();

        return [
            'total' => $total,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'tidak_hadir' => $tidakHadir,
            'persentase_hadir' => $total > 0 ? round(($hadir + $terlambat) / $total * 100, 2) : 0,
        ];
    }

    private function getKelasStats($kelasId)
    {
        $totalSessions = PresensiSession::where('kelas_id', $kelasId)->count();
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
        $tidakHadir = PresensiRecord::where('siswa_id', $siswaId)->where('status', 'tidak_hadir')->count();

        return [
            'total_records' => $totalRecords,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'tidak_hadir' => $tidakHadir,
            'persentase_hadir' => $totalRecords > 0 ? round(($hadir + $terlambat) / $totalRecords * 100, 2) : 0,
        ];
    }
}
