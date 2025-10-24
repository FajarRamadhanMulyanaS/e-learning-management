<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\GuruMapel;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\Quiz;
use App\Models\Siswa;

// ===== TAMBAHAN BARU =====
use Maatwebsite\Excel\Facades\Excel; // 1. Tambahkan fasad Excel
use App\Exports\LaporanNilaiExport;    // 2. Tambahkan class Export baru (akan kita buat)
// ==========================

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman utama laporan (daftar kelas).
     */
    public function index()
    {
        // Tidak ada perubahan
        $daftarKelas = Kelas::withCount('siswa')->orderBy('nama_kelas')->get();
        return view('admin.laporan.index', compact('daftarKelas'));
    }

    /**
     * Menampilkan detail satu kelas (daftar mata pelajaran).
     */
    public function showKelas($kelasId)
    {
        // Tidak ada perubahan
        $kelas = Kelas::findOrFail($kelasId);
        $daftarGuruMapel = GuruMapel::where('kelas_id', $kelas->id)
                                    ->with('mapel', 'user') // 'user' adalah relasi ke Guru
                                    ->get();
        return view('admin.laporan.show_kelas', compact('kelas', 'daftarGuruMapel'));
    }


    // ========================================================================
    // =====            PERUBAHAN BESAR DIMULAI DARI SINI           =====
    // ========================================================================

    /**
     * Private function untuk mengambil dan memproses data laporan.
     * Ini adalah inti logika yang dipindahkan dari showDetail.
     */
    private function getLaporanData($kelasId, $mapelId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $mapel = Mapel::findOrFail($mapelId);

        // 1. Dapatkan ID semua aktivitas
        $tugasIds = Tugas::where('mapel_id', $mapel->id)->where('kelas_id', $kelas->id)->pluck('id');
        $ujianIds = Ujian::where('mapel_id', $mapel->id)->where('kelas_id', $kelas->id)->pluck('id');
        $guruMapelIds = GuruMapel::where('mapel_id', $mapel->id)->where('kelas_id', $kelas->id)->pluck('id');
        $quizIds = Quiz::whereIn('guru_mapel_id', $guruMapelIds)->pluck('id');

        // 2. Ambil semua siswa di kelas, lalu Eager Load data
        $daftarSiswa = $kelas->siswa()->with([
            'pengumpulanTugas' => fn($q) => $q->whereIn('tugas_id', $tugasIds),
            'hasilUjian'       => fn($q) => $q->whereIn('ujian_id', $ujianIds),
            'quizSubmissions'  => fn($q) => $q->whereIn('quiz_id', $quizIds),
            'user'
        ])
        ->whereHas('user')
        ->get();

        // 3. Proses data untuk ditampilkan di view
        foreach ($daftarSiswa as $siswa) {
            $tugasNilai = $siswa->pengumpulanTugas->avg('nilai');
            $ujianNilai = $siswa->hasilUjian->avg('total_nilai'); 
            $quizNilai = $siswa->quizSubmissions->avg('nilai');
            
            $allNilai = collect([$tugasNilai, $ujianNilai, $quizNilai])->filter(fn($val) => !is_null($val));
            
            $siswa->avgTugas = round($tugasNilai, 2);
            $siswa->avgUjian = round($ujianNilai, 2);
            $siswa->avgQuiz = round($quizNilai, 2);
            $siswa->avgTotal = $allNilai->count() > 0 ? round($allNilai->avg(), 2) : 0;
        }

        // 4. Kembalikan data dalam bentuk array
        return compact('kelas', 'mapel', 'daftarSiswa');
    }

    /**
     * Menampilkan laporan akhir (nilai) ke halaman web.
     * (Sekarang memanggil helper)
     */
    public function showDetail($kelasId, $mapelId)
    {
        // Panggil helper untuk mendapatkan data
        $data = $this->getLaporanData($kelasId, $mapelId);
        
        // Kirim data ke view
        return view('admin.laporan.show_detail', $data);
    }

    /**
     * !! METHOD BARU UNTUK EXPORT EXCEL !!
     *
     * Menangani download laporan dalam format Excel.
     */
    public function exportExcel($kelasId, $mapelId)
    {
        // 1. Panggil helper yang sama untuk mendapatkan data yang identik
        $data = $this->getLaporanData($kelasId, $mapelId);

        // 2. Siapkan nama file
        $namaFile = 'laporan-nilai-' . 
                    \Str::slug($data['kelas']->nama_kelas) . '-' . 
                    \Str::slug($data['mapel']->nama_mapel) . '-' . 
                    now()->format('d-m-Y') . '.xlsx';

        // 3. Panggil class Export (yang akan kita buat) dan download
        return Excel::download(
            new LaporanNilaiExport(
                $data['daftarSiswa'], 
                $data['kelas'], 
                $data['mapel']
            ), 
            $namaFile
        );
    }
}