<?php

namespace App\Http\Controllers;

use db;
use Illuminate\Http\Request;
use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\GuruMapel;
use App\Models\Guru;
use App\Models\Materi;
use App\Models\User;
class GuruController extends Controller
{
    //
    public function index()
{
    // Mengambil ID guru yang sedang login
    $guruId = auth()->id();

    // Mengambil data kelas dan mapel yang diampu guru dari tabel guru_mapels
    $guruMapels = GuruMapel::with(['kelas', 'mapel'])
        ->where('user_id', $guruId)
        ->get();

    // Mengambil data materi yang di-upload oleh guru yang sedang login
    $materi = Materi::where('user_id', $guruId)->get();

    // Mengambil data siswa yang berada di kelas yang diajar oleh guru
    $kelasIds = $guruMapels->pluck('kelas_id'); // Mengambil ID kelas yang diajar oleh guru
    $siswa = User::whereIn('kelas_id', $kelasIds)
        ->where('role', 'siswa')
        ->get();

    return view('guru.index', compact('guruMapels', 'siswa', 'materi'));
}

    // Tampilkan profil guru
    public function show($id)
    {
        $guru = Guru::with('user')->findOrFail($id); // Mengambil siswa beserta user-nya
        return view('guru.profil_guru', compact('guru'));
    }

    public function profilGuru($id)
    {
        if (Auth::check() && Auth::user()->role === 'guru') {
            $guru = Guru::with('user')->find($id);

            if (!$guru) {
                return redirect()->back()->with('error', 'guru tidak ditemukan.');
            }

            $user = $guru->user;

            // Tambahkan ini untuk debugging
            dd($guru, $user); // Melihat isi variabel
        }

        return redirect('/home')->with('error', 'Akses ditolak, Anda bukan siswa.');
    }


    // tampilan daftar siswa
    public function daftarSiswa()
{
    // Mengambil ID guru yang sedang login
    $guruId = auth()->id();

    // Mengambil data kelas yang diampu oleh guru dari tabel guru_mapels
    $guruMapels = GuruMapel::where('user_id', $guruId)->with('kelas')->get();
    $kelasIds = $guruMapels->pluck('kelas_id');

    // Mengambil data siswa yang berada di kelas yang diajar oleh guru
    $siswa = User::whereIn('kelas_id', $kelasIds)
                 ->where('role', 'siswa')
                 ->with(['kelas', 'siswa']) // Menyertakan relasi siswa
                 ->get();

    return view('guru.daftar_siswa', compact('siswa'));
}



public function exportExcel($ujian_id)
{
    // Ambil kelas_id dari ujian yang dipilih
    $kelas_id = DB::table('ujian')->where('id', $ujian_id)->value('kelas_id');

    // Ambil data siswa yang sudah mengikuti ujian
    $siswaSudahUjian = DB::table('siswa')
        ->join('users', 'siswa.user_id', '=', 'users.id')
        ->join('kelas', 'users.kelas_id', '=', 'kelas.id')
        ->leftJoin('jawaban_siswa_pilgan', function ($join) use ($ujian_id) {
            $join->on('siswa.id', '=', 'jawaban_siswa_pilgan.siswa_id')
                 ->where('jawaban_siswa_pilgan.ujian_id', $ujian_id);
        })
        ->leftJoin('hasil_ujian', function ($join) use ($ujian_id) {
            $join->on('hasil_ujian.siswa_id', '=', 'siswa.id')
                 ->where('hasil_ujian.ujian_id', $ujian_id);
        })
        ->select(
            'siswa.nisn',
            'users.username as nama_siswa',
            'kelas.nama_kelas as kelas',
            'jawaban_siswa_pilgan.nilai_pg',
            'hasil_ujian.total_nilai_essay',
            DB::raw("COALESCE(jawaban_siswa_pilgan.nilai_pg, 0) + COALESCE(hasil_ujian.total_nilai_essay, 0) as jumlah")
        )
        ->where('kelas.id', $kelas_id)
        ->distinct()
        ->get();

    // Export data ke Excel
    return Excel::download(new SiswaExport($siswaSudahUjian), 'daftar_siswa_ujian.xlsx');
}



}
