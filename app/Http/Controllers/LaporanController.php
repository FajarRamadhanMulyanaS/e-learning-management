<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\GuruMapel;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\Quiz;
use App\Models\Siswa; // Pastikan Siswa di-import

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman utama laporan (daftar kelas).
     */
    public function index()
    {
        // Query ini sekarang 100% akurat karena 'siswa.kelas_id' sudah benar
        $daftarKelas = Kelas::withCount('siswa')->orderBy('nama_kelas')->get();
        return view('admin.laporan.index', compact('daftarKelas'));
    }

    /**
     * Menampilkan detail satu kelas (daftar mata pelajaran).
     */
    public function showKelas($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $daftarGuruMapel = GuruMapel::where('kelas_id', $kelas->id)
                                    ->with('mapel', 'user') // 'user' adalah relasi ke Guru
                                    ->get();
        return view('admin.laporan.show_kelas', compact('kelas', 'daftarGuruMapel'));
    }

    /**
     * Menampilkan laporan akhir (nilai).
     * Ini adalah versi FINAL yang bersih.
     */
    public function showDetail($kelasId, $mapelId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $mapel = Mapel::findOrFail($mapelId);

        // 1. Dapatkan ID semua aktivitas (Tidak berubah, ini sudah benar)
        $tugasIds = Tugas::where('mapel_id', $mapel->id)->where('kelas_id', $kelas->id)->pluck('id');
        $ujianIds = Ujian::where('mapel_id', $mapel->id)->where('kelas_id', $kelas->id)->pluck('id');
        $guruMapelIds = GuruMapel::where('mapel_id', $mapel->id)->where('kelas_id', $kelas->id)->pluck('id');
        $quizIds = Quiz::whereIn('guru_mapel_id', $guruMapelIds)->pluck('id');

        // 2. Ambil semua siswa di kelas, lalu Eager Load data
        //    (Query sekarang sederhana, karena 'siswa.kelas_id' sudah benar)
        //    !! PERUBAHAN BESAR ADA DI BLOK 'with' INI !!
        $daftarSiswa = $kelas->siswa()->with([
            
            // SEMUA relasi nilai sekarang diambil langsung dari $siswa
            'pengumpulanTugas' => fn($q) => $q->whereIn('tugas_id', $tugasIds),
            'hasilUjian'       => fn($q) => $q->whereIn('ujian_id', $ujianIds),
            'quizSubmissions'  => fn($q) => $q->whereIn('quiz_id', $quizIds),
            
            // Kita masih butuh relasi 'user' untuk mengambil 'username'
            'user'
        ])
        ->whereHas('user') // Hanya ambil siswa yang punya akun user
        ->get();

        // 3. Proses data untuk ditampilkan di view
        //    !! PERUBAHAN BESAR ADA DI KALKULASI INI !!
        foreach ($daftarSiswa as $siswa) {
            
            // --- Proses Nilai (Rata-rata) ---
            
            // Diambil dari relasi $siswa (BUKAN $siswa->user)
            $tugasNilai = $siswa->pengumpulanTugas->avg('nilai');
            
            // Diambil dari relasi $siswa (BUKAN $siswa->user)
            // Menggunakan kolom 'total_nilai' dari 'hasil_ujian'
            $ujianNilai = $siswa->hasilUjian->avg('total_nilai'); 
            
            // Diambil dari relasi $siswa (BUKAN $siswa->user)
            $quizNilai = $siswa->quizSubmissions->avg('nilai');
            
            $allNilai = collect([$tugasNilai, $ujianNilai, $quizNilai])->filter(fn($val) => !is_null($val));
            
            $siswa->avgTugas = round($tugasNilai, 2);
            $siswa->avgUjian = round($ujianNilai, 2);
            $siswa->avgQuiz = round($quizNilai, 2);
            $siswa->avgTotal = $allNilai->count() > 0 ? round($allNilai->avg(), 2) : 0;
        }

        return view('admin.laporan.show_detail', compact('kelas', 'mapel', 'daftarSiswa'));
    }
}

