<?php

namespace App\Http\Controllers;

use App\Models\PresensiSession;
use App\Models\PresensiRecord;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class PresensiController extends Controller
{
    public function index()
    {
        $guruId = Auth::id();

        $sessions = PresensiSession::with(['kelas', 'mapel', 'semester'])
            ->where('guru_id', $guruId)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->paginate(10);

        return view('guru.presensi.index', compact('sessions'));
    }
    

    public function create()
    {
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $semesters = Semester::all();

        return view('guru.presensi.create', compact('kelas', 'mapels', 'semesters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'semester_id' => 'nullable|exists:semesters,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        // Karena semua presensi pakai QR, set default mode ke 'qr'
        $validated['mode'] = 'qr';
        $validated['guru_id'] = Auth::id();
        $validated['is_active'] = true;
        $validated['is_closed'] = false;

        $session = PresensiSession::create($validated);

        // Generate QR Code otomatis
        $session->generateQRCode();

        // Buat record presensi untuk semua siswa di kelas
        $this->createPresensiRecords($session);

        return redirect()->route('guru.presensi.show', $session->id)
            ->with('success', 'Sesi presensi berhasil dibuat');
    }

    public function show($id)
    {
        $session = PresensiSession::with(['kelas', 'mapel', 'semester', 'presensiRecords.siswa'])
            ->findOrFail($id);

        // Pastikan hanya guru yang membuat sesi ini yang bisa melihat
        if ($session->guru_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke sesi presensi ini');
        }

        $stats = $session->getPresensiStats();

        return view('guru.presensi.show', compact('session', 'stats'));
    }

    public function close($id)
    {
        $session = PresensiSession::findOrFail($id);

        if ($session->guru_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke sesi presensi ini');
        }

        $session->closeSession();

        return redirect()->route('guru.presensi.index')
            ->with('success', 'Sesi presensi telah ditutup');
    }

    public function regenerateQR($id)
    {
        $session = PresensiSession::findOrFail($id);

        if ($session->guru_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke sesi presensi ini');
        }

        // Karena sekarang semua mode adalah QR, aman tanpa pengecekan
        $session->generateQRCode();

        return response()->json(['success' => true, 'message' => 'QR Code berhasil diperbarui']);
    }

    public function getActiveSessions()
    {
        $guruId = Auth::id();

        $sessions = PresensiSession::with(['kelas', 'mapel'])
            ->where('guru_id', $guruId)
            ->active()
            ->today()
            ->get();

        return response()->json($sessions);
    }
public function detail($id)
{
    // ambil data sesi dan relasi presensi siswa
    $session = PresensiSession::with(['kelas', 'guru', 'mapel', 'presensiRecords.siswa'])
                ->findOrFail($id);

    return view('admin.presensi.detail', compact('session'));
}

    public function getSessionStats($id)
    {
        $session = PresensiSession::findOrFail($id);

        if ($session->guru_id !== Auth::id()) {
            abort(403);
        }

        $stats = $session->getPresensiStats();

        return response()->json($stats);
    }
public function updateStatus(Request $request, $id)
{
    $record = PresensiRecord::findOrFail($id);

    $validStatuses = ['hadir', 'sakit', 'izin', 'tidak_hadir'];

    if (!in_array($request->status, $validStatuses)) {
        return response()->json(['success' => false, 'message' => 'Status tidak valid.']);
    }

    $record->status = $request->status;
    $record->save();

    return response()->json(['success' => true]);
}



    private function createPresensiRecords(PresensiSession $session)
    {
        // Ambil siswa dari kelas melalui relasi yang benar
        $siswaIds = collect();

        // Cek dari tabel siswa yang memiliki kelas_id
        $siswaFromSiswaTable = $session->kelas->siswa()->pluck('user_id');
        $siswaIds = $siswaIds->merge($siswaFromSiswaTable);

        // Hapus duplikat
        $siswaIds = $siswaIds->unique();

        foreach ($siswaIds as $siswaId) {
            PresensiRecord::create([
                'presensi_session_id' => $session->id,
                'siswa_id' => $siswaId,
                'status' => 'tidak_hadir',
            ]);
        }
    }
}
