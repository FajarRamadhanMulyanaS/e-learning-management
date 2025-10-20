<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\PilihanGanda;
use Illuminate\Http\Request;

class ManajemenPilihanGandaController extends Controller
{
    // Menampilkan daftar soal pilihan ganda terkait dengan ujian
    public function index($ujian_id)
    {
        // Menampilkan soal pilihan ganda berdasarkan ujian_id
        $ujianTugas = Ujian::paginate(10);
        $soalPilihanGanda = PilihanGanda::where('ujian_id', $ujian_id)->paginate(10);
        return view('guru.manajemen-ujian.pilihan-ganda', compact('soalPilihanGanda','ujianTugas', 'ujian_id'));
    }

    // Menyimpan soal pilihan ganda baru
    public function storePilgan(Request $request, $ujian_id)
    {
        $request->validate([
            'soal' => 'required',
            'pilihan_a' => 'required',
            'pilihan_b' => 'required',
            'pilihan_c' => 'required',
            'pilihan_d' => 'required',
            'pilihan_e' => '',
            'kunci_jawaban' => 'required',
        ]);

        // Menambahkan soal baru dan mengaitkan dengan ujian_id
        PilihanGanda::create([
            'ujian_id' => $ujian_id,  // Terhubung dengan ujian
            'soal' => $request->soal,
            'pilihan_a' => $request->pilihan_a,
            'pilihan_b' => $request->pilihan_b,
            'pilihan_c' => $request->pilihan_c,
            'pilihan_d' => $request->pilihan_d,
            'pilihan_e' => $request->pilihan_e,
            'kunci_jawaban' => $request->kunci_jawaban,
        ]);

        return redirect()->route('guru.manajemen-ujian.pilihan-ganda', $ujian_id)->with('success', 'Soal Pilihan Ganda berhasil ditambahkan.');
    }

    // Mengupdate soal pilihan ganda yang ada
    public function update(Request $request, $ujian_id, $id)
    {
        $request->validate([
            'soal' => 'required',
            'pilihan_a' => 'required',
            'pilihan_b' => 'required',
            'pilihan_c' => 'required',
            'pilihan_d' => 'required',
            'pilihan_e' => '',
            'kunci_jawaban' => 'required',
        ]);

        $soalPilihanGanda = PilihanGanda::findOrFail($id);
        $soalPilihanGanda->update($request->all());

        return redirect()->route('guru.manajemen-ujian.pilihan-ganda', $ujian_id)->with('success', 'Soal Pilihan Ganda berhasil diperbarui.');
    }

    // Menghapus soal pilihan ganda
    public function destroy($ujian_id, $id)
    {
        PilihanGanda::findOrFail($id)->delete();
        return redirect()->route('guru.manajemen-ujian.pilihan-ganda', $ujian_id)->with('success', 'Soal Pilihan Ganda berhasil dihapus.');
    }


}
