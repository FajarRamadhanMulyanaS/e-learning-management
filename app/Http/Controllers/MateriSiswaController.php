<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Mapel;
class MateriSiswaController extends Controller
{
    public function indexIndo(Request $request)
{
    // ID untuk mata pelajaran Bahasa Indonesia
    $bahasaIndonesiaId = 1; // Sesuaikan dengan ID yang ada di tabel mapels

    // Ambil kelas_id dari user yang sedang login melalui relasi siswa
    $user = auth()->user();
    
    // Pastikan user memiliki relasi siswa
    if (!$user->siswa) {
        return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
    }
    
    $kelasId = $user->siswa->kelas_id;

    // Ambil data materi berdasarkan mapel_id dan kelas_id yang sedang login
    $materis = Materi::where('mapel_id', $bahasaIndonesiaId)
                     ->where('kelas_id', $kelasId)
                     ->get();

    // Ambil nama mata pelajaran
    $mapel = Mapel::findOrFail($bahasaIndonesiaId);

    return view('siswa.materi.indonesia.index', compact('materis', 'mapel'));
}
public function indexMatematika(Request $request)
{
    // ID untuk mata pelajaran Matematika
    $matematikaId = 2; // Pastikan ID sesuai dengan tabel mapels

    // Ambil kelas_id dari user yang sedang login melalui relasi siswa
    $user = auth()->user();
    
    // Pastikan user memiliki relasi siswa
    if (!$user->siswa) {
        return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
    }
    
    $kelasId = $user->siswa->kelas_id;

    // Ambil data materi yang hanya untuk Matematika dan kelas siswa yang sedang login
    $materis = Materi::where('mapel_id', $matematikaId)
                     ->where('kelas_id', $kelasId)
                     ->get();

    // Ambil nama mata pelajaran untuk ditampilkan
    $mapel = Mapel::find($matematikaId);

    // Pastikan variabel $mapel tidak kosong, dan kirim ke view jika data ditemukan
    if (!$mapel) {
        abort(404, 'Mata pelajaran tidak ditemukan.');
    }

    return view('siswa.materi.matematika.index', compact('materis', 'mapel'));
}


}
