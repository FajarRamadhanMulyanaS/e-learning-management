<?php

namespace App\Http\Controllers;

use App\Models\PresensiSession;
use App\Models\PresensiRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaPresensiController extends Controller
{
    public function index()
    {
        $siswaId = Auth::id();
        $user = Auth::user();

        // Cek kelas dari tabel siswa atau user
        $kelasId = null;
        if ($user->siswa && $user->siswa->kelas_id) {
            $kelasId = $user->siswa->kelas_id;
        } elseif ($user->kelas_id) {
            $kelasId = $user->kelas_id;
        }

        if (!$kelasId) {
            return view('siswa.presensi.index')->with('error', 'Anda belum terdaftar di kelas manapun');
        }

        // Ambil sesi presensi aktif untuk kelas siswa
        $activeSessions = PresensiSession::with(['kelas', 'mapel', 'guru'])
            ->where('kelas_id', $kelasId)
            ->active()
            ->today()
            ->get();

        // Ambil riwayat presensi siswa
        $presensiHistory = PresensiRecord::with(['presensiSession.kelas', 'presensiSession.mapel', 'presensiSession.guru'])
            ->where('siswa_id', $siswaId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('siswa.presensi.index', compact('activeSessions', 'presensiHistory'));
    }

   public function checkIn(Request $request)
{
    $sessionId = $request->input('session_id');
    $qrCode = $request->input('qr_code');
    $metode = $request->input('metode');

    if (!$sessionId) {
        return response()->json(['success' => false, 'error' => 'Session ID tidak ditemukan']);
    }

    $validated = $request->validate([
        'session_id' => 'required|exists:presensi_sessions,id',
        'metode' => 'required|in:qr,manual',
        'qr_code' => 'nullable|string',
    ]);

    $session = PresensiSession::findOrFail($validated['session_id']);
    $siswaId = Auth::id();

    /**
     * ==============================
     * 🔍 VALIDASI KHUSUS QR CODE
     * ==============================
     */
    if ($validated['metode'] === 'qr') {
        $qrInput = trim($validated['qr_code']);

        // ✅ Pola QR baru: PRESENSI_{id}_{timestamp}_{kodeacak}
        if (preg_match('/^PRESENSI_(\d+)_(\d+)_(\d+)$/', $qrInput, $matches)) {
            $qrSessionId = (int)$matches[1];
            $qrTimestamp = $matches[2];
            $qrRandom = $matches[3];

            // Pastikan session ID cocok
            if ($qrSessionId !== (int)$session->id) {
                return response()->json(['error' => 'QR Code bukan milik sesi ini'], 400);
            }

            // Pastikan kode QR di DB sama persis
            if ($session->qr_code !== $qrInput) {
                return response()->json(['error' => 'QR Code tidak cocok dengan sesi ini'], 400);
            }

            // Cek masa berlaku QR
            if (!$session->isQRValid()) {
                return response()->json(['error' => 'QR Code sudah expired'], 400);
            }
        } else {
            return response()->json(['error' => 'Format QR Code tidak dikenali'], 400);
        }
    }

    /**
     * ==============================
     * ⏰ PROSES ABSEN
     * ==============================
     */
    $existingRecord = PresensiRecord::where('presensi_session_id', $session->id)
        ->where('siswa_id', $siswaId)
        ->first();

    if ($existingRecord && $existingRecord->status !== 'tidak_hadir') {
        return response()->json(['error' => 'Anda sudah melakukan absen'], 400);
    }

    $now = now();
    $isLate = $now->gt($session->jam_mulai);

    if ($existingRecord) {
        $existingRecord->doAbsen($validated['metode']);
        $existingRecord->status = $isLate ? 'terlambat' : 'hadir';
        $existingRecord->save();
        $status = $existingRecord->status;
    } else {
        $record = PresensiRecord::create([
            'presensi_session_id' => $session->id,
            'siswa_id' => $siswaId,
            'status' => $isLate ? 'terlambat' : 'hadir',
            'metode_absen' => $validated['metode'],
            'waktu_absen' => $now,
        ]);
        $status = $record->status;
    }

    $updatedRecord = PresensiRecord::where('presensi_session_id', $session->id)
        ->where('siswa_id', $siswaId)
        ->first();

    return response()->json([
        'success' => 'Absen berhasil',
        'status' => $status,
        'waktu_absen' => $updatedRecord->waktu_absen_formatted,
        'status_text' => $status === 'hadir' ? 'Hadir' : ($status === 'terlambat' ? 'Terlambat' : 'Tidak Hadir')
    ]);
}



 public function validateQR(Request $request)
{
    $request->validate([
        'qr_code' => 'required|string',
    ]);

    // Cari session presensi berdasarkan kode QR
    $session = PresensiSession::where('qr_code', $request->qr_code)
        ->where(function ($query) {
            $query->whereNull('qr_expires_at')
                  ->orWhere('qr_expires_at', '>=', now());
        })
        ->first();

    // Jika tidak ditemukan atau sudah kedaluwarsa
    if (!$session) {
        return response()->json([
            'valid' => false,
            'message' => 'QR Code tidak valid atau sudah kedaluwarsa.',
        ]);
    }

    // Pastikan session masih aktif (opsional jika kamu punya scope "active()")
    if (method_exists($session, 'isActive') && !$session->isActive()) {
        return response()->json([
            'valid' => false,
            'message' => 'Sesi presensi ini sudah tidak aktif.',
        ]);
    }

    // Jika valid, kembalikan ID sesi untuk proses absen
    return response()->json([
        'valid' => true,
        'session_id' => $session->id,
        'message' => 'QR Code valid, lanjutkan presensi.',
    ]);
}


    public function getPresensiStatus($sessionId)
    {
        $siswaId = Auth::id();

        $record = PresensiRecord::where('presensi_session_id', $sessionId)
            ->where('siswa_id', $siswaId)
            ->first();

        if (!$record) {
            return response()->json([
                'status' => 'tidak_hadir',
                'waktu_absen' => null,
                'status_text' => 'Tidak Hadir'
            ]);
        }

        $statusText = match ($record->status) {
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'tidak_hadir' => 'Tidak Hadir',
            default => 'Tidak Hadir'
        };

        return response()->json([
            'status' => $record->status,
            'waktu_absen' => $record->waktu_absen_formatted,
            'metode_absen' => $record->metode_absen,
            'status_text' => $statusText
        ]);
    }

    public function history()
    {
        $siswaId = Auth::id();

        $presensiHistory = PresensiRecord::with(['presensiSession.kelas', 'presensiSession.mapel', 'presensiSession.guru'])
            ->where('siswa_id', $siswaId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('siswa.presensi.history', compact('presensiHistory'));
    }
}
