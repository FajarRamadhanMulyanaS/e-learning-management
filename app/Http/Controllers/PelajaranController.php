<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Semester;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class PelajaranController extends Controller
{
    public function jadwal()
    {
        $user = Auth::user();

        // Ambil data siswa yang sedang login
        $siswa = $user->siswa;

        if (!$siswa) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Ambil kelas ID dari siswa
        $kelasId = $siswa->kelas_id;

        // Ambil semester aktif
        $activeSemester = Semester::active()->first();

        // Ambil jadwal berdasarkan kelas dan semester aktif
        $jadwal = Jadwal::with(['kelas', 'mapel', 'user'])
            ->when($kelasId, function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            })
            ->when($activeSemester, function ($q) use ($activeSemester) {
                $q->where('semester_id', $activeSemester->id);
            })
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        // Kirim data ke view
        return view('siswa.jadwal', compact('jadwal', 'activeSemester', 'siswa'));
    }

    // --- Sisa fungsi tetap ---
    public function indo()
    {
        return view('siswa.pelajaran.bhs_indo');
    }
    public function inggris()
    {
        return view('siswa.pelajaran.bhs_inggris');
    }
    public function mtk()
    {
        return view('siswa.pelajaran.mtk');
    }
    public function ipa()
    {
        return view('siswa.pelajaran.ipa');
    }
    public function ips()
    {
        return view('siswa.pelajaran.ips');
    }
    public function bk()
    {
        return view('siswa.pelajaran.bk');
    }
    public function agama()
    {
        return view('siswa.pelajaran.pai');
    }
    public function pjok()
    {
        return view('siswa.pelajaran.pjok');
    }
    public function ppkn()
    {
        return view('siswa.pelajaran.ppkn');
    }
    public function informatika()
    {
        return view('siswa.pelajaran.informatika');
    }
    public function seni()
    {
        return view('siswa.pelajaran.seni');
    }
    public function jawa()
    {
        return view('siswa.pelajaran.bhs_jawa');
    }
}
