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
        $kelasId = Auth::user()->kelas_id;

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
        $validated = $request->validate([
            'session_id' => 'required|exists:presensi_sessions,id',
            'metode' => 'required|in:qr,manual',
            'qr_code' => 'nullable|string',
        ]);

        $session = PresensiSession::findOrFail($validated['session_id']);
        $siswaId = Auth::id();

        // Validasi QR Code jika metode QR
        if ($validated['metode'] === 'qr') {
            if (!$session->qr_code || $session->qr_code !== $validated['qr_code']) {
                return response()->json(['error' => 'QR Code tidak valid'], 400);
            }

            if (!$session->isQRValid()) {
                return response()->json(['error' => 'QR Code sudah expired'], 400);
            }
        }

        // Cek apakah siswa sudah absen
        $existingRecord = PresensiRecord::where('presensi_session_id', $session->id)
            ->where('siswa_id', $siswaId)
            ->first();

        if ($existingRecord && $existingRecord->status !== 'tidak_hadir') {
            return response()->json(['error' => 'Anda sudah melakukan absen'], 400);
        }

        // Lakukan absen
        if ($existingRecord) {
            $existingRecord->doAbsen($validated['metode']);
        } else {
            PresensiRecord::create([
                'presensi_session_id' => $session->id,
                'siswa_id' => $siswaId,
                'status' => 'tidak_hadir',
            ])->doAbsen($validated['metode']);
        }

        return response()->json(['success' => 'Absen berhasil']);
    }

    public function validateQR(Request $request)
    {
        $validated = $request->validate([
            'qr_code' => 'required|string',
        ]);

        $session = PresensiSession::where('qr_code', $validated['qr_code'])
            ->active()
            ->first();

        if (!$session) {
            return response()->json(['valid' => false, 'message' => 'QR Code tidak valid']);
        }

        if (!$session->isQRValid()) {
            return response()->json(['valid' => false, 'message' => 'QR Code sudah expired']);
        }

        $siswaId = Auth::id();
        $kelasId = Auth::user()->kelas_id;

        if ($session->kelas_id !== $kelasId) {
            return response()->json(['valid' => false, 'message' => 'QR Code tidak untuk kelas Anda']);
        }

        return response()->json([
            'valid' => true,
            'session' => [
                'id' => $session->id,
                'mapel' => $session->mapel->nama_mapel,
                'guru' => $session->guru->username,
                'jam_mulai' => $session->jam_mulai_formatted,
            ]
        ]);
    }

    public function getPresensiStatus($sessionId)
    {
        $siswaId = Auth::id();

        $record = PresensiRecord::where('presensi_session_id', $sessionId)
            ->where('siswa_id', $siswaId)
            ->first();

        if (!$record) {
            return response()->json(['status' => 'tidak_hadir', 'waktu_absen' => null]);
        }

        return response()->json([
            'status' => $record->status,
            'waktu_absen' => $record->waktu_absen_formatted,
            'metode_absen' => $record->metode_absen,
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
