<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\JawabanSiswaEssay;
use App\Models\Ujian;
use App\Models\HasilUjian;

class KoreksiEssayController extends Controller
{
    // Menampilkan halaman koreksi
    public function showKoreksi($ujian_id, $siswa_id)
{
    $ujian = Ujian::with([
        'user.kelas', // Memuat data user dan kelas siswa dari tabel users
        'essay',
        'jawabanEssay' => function ($query) use ($siswa_id) {
            $query->where('siswa_id', $siswa_id);
        }
    ])->findOrFail($ujian_id);

    return view('guru.manajemen-ujian.koreksi.koreksi_essay', compact('ujian'));
}






public function koreksiNilai(Request $request, $jawaban_id)
{
    // Validasi input
    $request->validate([
        'nilai' => 'required|numeric|min:0|max:100',
        'koreksi' => 'nullable|string', // Jika ada koreksi
    ]);

    // Cari jawaban berdasarkan id
    $jawaban = JawabanSiswaEssay::findOrFail($jawaban_id);

    // Update nilai essay untuk soal tertentu
    $jawaban->nilai_essay = $request->input('nilai');

    // Jika ada koreksi, simpan juga
    if ($request->has('koreksi')) {
        $jawaban->koreksi = $request->input('koreksi');
    }

    $jawaban->save();

    // Hitung total nilai essay untuk siswa dan ujian ini
    $this->hitungTotalNilaiEssay($jawaban->ujian_id, $jawaban->siswa_id);

    // Redirect ke halaman daftar siswa setelah koreksi selesai
    return back()->with('success', 'Nilai berhasil dikoreksi.');
}

private function hitungTotalNilaiEssay($ujian_id, $siswa_id)
{
    // Ambil semua jawaban essay siswa untuk ujian ini
    $jawabanSiswa = JawabanSiswaEssay::where('ujian_id', $ujian_id)
                                      ->where('siswa_id', $siswa_id)
                                      ->get();

    // Hitung total nilai
    $totalNilai = $jawabanSiswa->sum('nilai_essay');

    // Periksa apakah hasil ujian sudah ada di tabel hasil_ujian untuk kombinasi ujian_id dan siswa_id
    $hasilUjian = HasilUjian::where('ujian_id', $ujian_id)
                             ->where('siswa_id', $siswa_id)
                             ->first();

    // Jika tidak ada, buat data baru; jika ada, perbarui
    if ($hasilUjian) {
        $hasilUjian->total_nilai_essay = $totalNilai;
        $hasilUjian->save();
    } else {
        HasilUjian::create([
            'ujian_id' => $ujian_id,
            'siswa_id' => $siswa_id,
            'total_nilai_essay' => $totalNilai
        ]);
    }
}


}
