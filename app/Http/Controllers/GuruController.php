<?php

namespace App\Http\Controllers;

// Ganti 'db' dengan 'use Illuminate\Support\Facades\DB;'
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\GuruMapel;
use App\Models\Guru;
use App\Models\Materi;
use App\Models\User;
// Tambahkan use Siswa jika belum ada
use App\Models\Siswa;

class GuruController extends Controller
{
    /**
     * Menampilkan dashboard guru.
     *
     * !! METHOD INI DIPERBAIKI !!
     */
    public function index()
    {
        // Mengambil ID guru (user) yang sedang login
        $guruUserId = Auth::id(); // Gunakan Auth::id() lebih singkat

        // Mengambil data kelas dan mapel yang diampu guru
        $guruMapels = GuruMapel::with(['kelas', 'mapel'])
                        ->where('user_id', $guruUserId)
                        ->get();

        // Mengambil data materi yang di-upload oleh guru
        $materi = Materi::where('user_id', $guruUserId)->get(); // Asumsi Materi terhubung ke User Guru

        // Mengambil ID kelas-kelas yang diajar oleh guru
        $kelasIds = $guruMapels->pluck('kelas_id')->unique()->filter(); // filter() untuk hapus null jika ada

        // Mengambil data siswa (sebagai User) yang berada di kelas yang diajar oleh guru
        // !! INI QUERY YANG DIPERBAIKI !!
        $siswa = User::where('role', 'siswa')
                    ->whereHas('siswa', function ($query) use ($kelasIds) {
                        // Filter berdasarkan siswa.kelas_id
                        $query->whereIn('kelas_id', $kelasIds);
                    })
                    ->with(['siswa', 'siswa.kelas']) // Eager load data siswa & kelasnya
                    ->get();

        return view('guru.index', compact('guruMapels', 'siswa', 'materi')); // Sesuaikan nama view jika perlu
    }

    // Tampilkan profil guru (Method show sepertinya tidak terpakai, profilGuru yang dipakai)
    // public function show($id)
    // {
    //     $guru = Guru::with('user')->findOrFail($id);
    //     return view('guru.profil_guru', compact('guru'));
    // }

    /**
     * Menampilkan halaman profil guru.
     * (Saya perbaiki sedikit logikanya dan menghapus dd())
     */
    public function profilGuru($id) // Parameter $id ini adalah User ID guru
    {
        // Ambil user yang sedang login
        $loggedInUser = Auth::user();

        // Pastikan user login adalah guru dan ID nya cocok dengan ID di URL
        if ($loggedInUser && $loggedInUser->role === 'guru' && $loggedInUser->id == $id) {
            // Ambil data User guru beserta relasi Guru (profil detail)
            $userGuru = User::with('guru')->find($id);

            if (!$userGuru) {
                return redirect()->back()->with('error', 'Guru tidak ditemukan.');
            }

            // Kirim data userGuru (yang sudah include data guru) ke view
            return view('guru.profil_guru', compact('userGuru')); // Sesuaikan nama view jika perlu
        }

        // Jika bukan guru atau ID tidak cocok
        return redirect()->route('guru.index')->with('error', 'Akses ditolak.'); // Redirect ke dashboard guru
    }


    /**
     * Menampilkan daftar siswa yang diajar oleh guru.
     *
     * !! METHOD INI DIPERBAIKI !!
     */
    public function daftarSiswa()
    {
        // Mengambil ID guru (user) yang sedang login
        $guruUserId = Auth::id();

        // Mengambil ID kelas-kelas yang diajar oleh guru
        $kelasIds = GuruMapel::where('user_id', $guruUserId)->pluck('kelas_id')->unique()->filter();

        // Mengambil data siswa (sebagai User) yang berada di kelas yang diajar oleh guru
        // !! INI QUERY YANG DIPERBAIKI !!
        $siswa = User::where('role', 'siswa')
                    ->whereHas('siswa', function ($query) use ($kelasIds) {
                        // Filter berdasarkan siswa.kelas_id
                        $query->whereIn('kelas_id', $kelasIds);
                    })
                    ->with(['siswa', 'siswa.kelas']) // Eager load data siswa & kelasnya
                    ->get();

        return view('guru.daftar_siswa', compact('siswa')); // Sesuaikan nama view jika perlu
    }


    /**
     * Export data nilai ujian siswa ke Excel.
     *
     * !! METHOD INI JUGA DIPERBAIKI agar lebih Eloquent & pakai siswa.kelas_id !!
     */
    public function exportExcel($ujian_id)
    {
        // 1. Ambil data ujian untuk mendapatkan kelas_id dan mapel_id
        $ujian = DB::table('ujian')->find($ujian_id); // Asumsi tabel ujian
        if (!$ujian) {
            return redirect()->back()->with('error', 'Ujian tidak ditemukan.');
        }
        $kelas_id = $ujian->kelas_id;
        $mapel_id = $ujian->mapel_id; // Kita mungkin butuh ini nanti

        // 2. Ambil data siswa (User) di kelas tersebut beserta hasil ujiannya
        $siswaSudahUjian = User::where('role', 'siswa')
            ->whereHas('siswa', function($q) use ($kelas_id) {
                $q->where('kelas_id', $kelas_id);
            })
            ->with([
                'siswa', // Ambil data NISN dari sini
                'siswa.kelas', // Ambil nama kelas
                // Load hasil ujian HANYA untuk ujian_id ini
                'siswa.hasilUjian' => function ($query) use ($ujian_id) {
                    $query->where('ujian_id', $ujian_id);
                }
                // Anda mungkin perlu relasi jawabanPilgan dan jawabanEssay di model Siswa
                // 'siswa.jawabanPilgan' => fn($q) => $q->where('ujian_id', $ujian_id),
                // 'siswa.jawabanEssay' => fn($q) => $q->where('ujian_id', $ujian_id),
            ])
            ->get()
            // Kita proses datanya agar sesuai format export
            ->map(function ($user) {
                $hasil = $user->siswa->hasilUjian->first(); // Ambil hasil ujian pertama (asumsi 1 siswa 1 hasil per ujian)
                return [
                    'nisn' => $user->siswa->nisn ?? 'N/A',
                    'nama_siswa' => $user->username,
                    'kelas' => $user->siswa->kelas->nama_kelas ?? 'N/A',
                    'nilai_pg' => $hasil->total_nilai_pilgan ?? 0, // Ambil dari hasil_ujian
                    'total_nilai_essay' => $hasil->total_nilai_essay ?? 0, // Ambil dari hasil_ujian
                    'jumlah' => $hasil->total_nilai ?? 0, // Ambil total nilai jika ada
                ];
            });


        // Export data ke Excel
        return Excel::download(new SiswaExport($siswaSudahUjian), 'daftar_siswa_ujian.xlsx');
    }
}
