<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Ujian;
use app\Models\HasilUjian;
use app\Models\JawabanSiswaEssay;
use app\Models\JawabanSiswaPilgan;
class HasilUjianController extends Controller
{
    //
    public function submitPilgan(Request $request, $ujian_id)
{
    $ujian = Ujian::findOrFail($ujian_id);
    $siswa_id = auth()->user()->id; // Ambil ID siswa yang mengerjakan
    $jawabanSiswa = $request->input('jawaban', []);

    // Buat entri di tabel hasil_ujian
    $hasilUjian = HasilUjian::create([
        'ujian_id' => $ujian->id,
        'siswa_id' => $siswa_id,
        'status_selesai' => false,
    ]);

    $jumlahBenar = 0;

    foreach ($ujian->soalPilihanGanda as $soal) {
        $jawaban = $jawabanSiswa[$soal->id] ?? null;
        $benar = $jawaban == $soal->jawaban_benar ? true : false;
        if ($benar) {
            $jumlahBenar++;
        }

        // Simpan jawaban siswa ke database
        JawabanSiswaPilgan::create([
            'hasil_ujian_id' => $hasilUjian->id,
            'soal_id' => $soal->id,
            'jawaban_siswa' => $jawaban,
            'benar' => $benar,
        ]);
    }

    // Hitung nilai pilihan ganda
    $nilaiPilgan = ($jumlahBenar / $ujian->soalPilihanGanda->count()) * 100;

    // Update nilai di hasil ujian
    $hasilUjian->update([
        'nilai_pilgan' => $nilaiPilgan,
        'status_selesai' => true,
    ]);

    return redirect()->route('ujian.hasil', $ujian->id)->with('success', 'Ujian selesai! Skor Anda: ' . $nilaiPilgan);
}

// =================================================================================================================

public function submitEssay(Request $request, $ujian_id)
{
    $ujian = Ujian::findOrFail($ujian_id);
    $siswa_id = auth()->user()->id;
    $jawabanSiswa = $request->input('jawaban', []);

    // Buat entri di tabel hasil_ujian jika belum ada
    $hasilUjian = HasilUjian::firstOrCreate([
        'ujian_id' => $ujian->id,
        'siswa_id' => $siswa_id,
    ]);

    // Simpan jawaban essay ke database
    foreach ($ujian->soalEssay as $soal) {
        JawabanSiswaEssay::create([
            'hasil_ujian_id' => $hasilUjian->id,
            'soal_id' => $soal->id,
            'jawaban_siswa' => $jawabanSiswa[$soal->id] ?? null,
        ]);
    }

    return redirect()->route('ujian.hasil', $ujian->id)->with('success', 'Jawaban essay berhasil disimpan. Nilai akan diberikan oleh pengajar.');
}

}
