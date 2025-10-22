<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\GuruMapel;
use App\Models\PresensiSession;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\Quiz;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman utama laporan (daftar kelas).
     */
    public function index()
    {
        $daftarKelas = Kelas::withCount('siswa')->orderBy('nama_kelas')->get();

        return view('admin.laporan.index', compact('daftarKelas'));
    }

    /**
     * Menampilkan detail satu kelas (daftar mata pelajaran).
     * * !! PERUBAHAN DI SINI !!
     * Mengubah (Kelas $kelas) menjadi ($kelasId) agar sesuai
     * dengan cara pemanggilan route di web.php
     */
    public function showKelas($kelasId) // <-- BERUBAH: Tidak lagi type-hint Model
    {
        $kelas = Kelas::findOrFail($kelasId); // <-- TAMBAHAN: Cari manual

        $daftarGuruMapel = GuruMapel::where('kelas_id', $kelas->id)
                                    ->with('mapel', 'user') // 'user' adalah relasi ke Guru
                                    ->get();

        return view('admin.laporan.show_kelas', compact('kelas', 'daftarGuruMapel'));
    }

    /**
     * Menampilkan laporan akhir (nilai & presensi).
     * * !! PERUBAHAN DI SINI !!
     * Mengubah (Kelas $kelas, $mapelId) menjadi ($kelasId, $mapelId)
     */
    public function showDetail($kelasId, $mapelId) // <-- BERUBAH: Tidak lagi type-hint Model
    {
        $kelas = Kelas::findOrFail($kelasId); // <-- TAMBAHAN: Cari manual
        $mapel = Mapel::findOrFail($mapelId); // <-- TAMBAHAN: Cari manual

        // 1. Dapatkan ID semua aktivitas yang terkait dengan mapel & kelas ini
        $sessionIds = PresensiSession::where('kelas_id', $kelas->id)->where('mapel_id', $mapel->id)->pluck('id');
        $tugasIds = Tugas::where('mapel_id', $mapel->id)->where('kelas_id', $kelas->id)->pluck('id');
        $ujianIds = Ujian::where('mapel_id', $mapel->id)->where('kelas_id', $kelas->id)->pluck('id');
        
        $guruMapelIds = GuruMapel::where('mapel_id', $mapel->id)->where('kelas_id', $kelas->id)->pluck('id');
        $quizIds = Quiz::whereIn('guru_mapel_id', $guruMapelIds)->pluck('id');

        // 2. Ambil semua siswa di kelas, lalu Eager Load semua data relevan
        $daftarSiswa = $kelas->siswa()->with([
            'user' => function($query) use ($sessionIds, $tugasIds, $ujianIds, $quizIds) {
                $query->with([
                    'presensiRecords' => fn($q) => $q->whereIn('presensi_session_id', $sessionIds),
                    'pengumpulanTugas' => fn($q) => $q->whereIn('tugas_id', $tugasIds),
                    'hasilUjian' => fn($q) => $q->whereIn('ujian_id', $ujianIds),
                    'quizSubmissions' => fn($q) => $q->whereIn('quiz_id', $quizIds)
                ]);
            }
        ])->get();

        // 3. Proses data untuk ditampilkan di view
        foreach ($daftarSiswa as $siswa) {
            if ($siswa->user) {
                // Proses Presensi
                $presensi = $siswa->user->presensiRecords;
                $siswa->totalHadir = $presensi->where('status', 'hadir')->count();
                $siswa->totalIzin = $presensi->where('status', 'izin')->count();
                $siswa->totalSakit = $presensi->where('status', 'sakit')->count(); 
                $siswa->totalAlpa = $presensi->where('status', 'alpa')->count(); 
                $siswa->totalTerlambat = $presensi->where('status', 'terlambat')->count();

                // Proses Nilai (Rata-rata)
                $tugasNilai = $siswa->user->pengumpulanTugas->avg('nilai');
                
                $ujianNilai = $siswa->user->hasilUjian->avg(function ($hasil) {
                    return ($hasil->nilai_pilgan ?? 0) + ($hasil->total_nilai_essay ?? 0);
                });
                
                $quizNilai = $siswa->user->quizSubmissions->avg('nilai');
                
                $allNilai = collect([$tugasNilai, $ujianNilai, $quizNilai])->filter(fn($val) => !is_null($val));
                
                $siswa->avgTugas = round($tugasNilai, 2);
                $siswa->avgUjian = round($ujianNilai, 2);
                $siswa->avgQuiz = round($quizNilai, 2);
                $siswa->avgTotal = $allNilai->count() > 0 ? round($allNilai->avg(), 2) : 0;
            }
        }

        return view('admin.laporan.show_detail', compact('kelas', 'mapel', 'daftarSiswa'));
    }
}