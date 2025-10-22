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
     * 🟢 Langkah 1 — Menampilkan daftar kelas
     */
    public function index()
    {
        $daftarKelas = Kelas::withCount('siswa')
            ->orderBy('nama_kelas')
            ->get();

        return view('admin.laporan.index', compact('daftarKelas'));
    }

    /**
     * 🟢 Langkah 2 — Menampilkan daftar mapel di satu kelas
     */
    public function showKelas($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);

        $daftarGuruMapel = GuruMapel::where('kelas_id', $kelas->id)
            ->with(['mapel', 'user']) // relasi ke mapel dan guru
            ->get();

        return view('admin.laporan.show_kelas', compact('kelas', 'daftarGuruMapel'));
    }

    /**
     * 🟢 Langkah 3 — Menampilkan laporan nilai dan presensi
     */
    public function showDetail($kelasId, $mapelId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $mapel = Mapel::findOrFail($mapelId);

        // Ambil ID aktivitas terkait mapel & kelas
        $sessionIds = PresensiSession::where('kelas_id', $kelas->id)
            ->where('mapel_id', $mapel->id)
            ->pluck('id');

        $tugasIds = Tugas::where('mapel_id', $mapel->id)
            ->where('kelas_id', $kelas->id)
            ->pluck('id');

        $ujianIds = Ujian::where('mapel_id', $mapel->id)
            ->where('kelas_id', $kelas->id)
            ->pluck('id');

        $guruMapelIds = GuruMapel::where('mapel_id', $mapel->id)
            ->where('kelas_id', $kelas->id)
            ->pluck('id');

        $quizIds = Quiz::whereIn('guru_mapel_id', $guruMapelIds)->pluck('id');

        // Ambil siswa dan semua relasi terkait langsung dari model Siswa
        $daftarSiswa = $kelas->siswa()->with([
            'user', // ambil data user (nama, email, dll)
            'pengumpulanTugas' => fn($q) => $q->whereIn('tugas_id', $tugasIds),
            'hasilUjian' => fn($q) => $q->whereIn('ujian_id', $ujianIds),
            'quizSubmissions' => fn($q) => $q->whereIn('quiz_id', $quizIds),
        ])->get();

        // Proses data untuk setiap siswa
        foreach ($daftarSiswa as $siswa) {
            // ✅ Rata-rata nilai tugas
            $tugasNilai = $siswa->pengumpulanTugas->avg('nilai');

            // ✅ Rata-rata nilai ujian
            $ujianNilai = $siswa->hasilUjian->avg(function ($hasil) {
                return ($hasil->total_nilai_pilgan ?? 0) + ($hasil->total_nilai_essay ?? 0);
            });

            // ✅ Rata-rata nilai quiz
            $quizNilai = $siswa->quizSubmissions->avg('nilai');

            // ✅ Gabungan semua nilai untuk total rata-rata
            $allNilai = collect([$tugasNilai, $ujianNilai, $quizNilai])
                ->filter(fn($val) => !is_null($val));

            $siswa->avgTugas = round($tugasNilai, 2);
            $siswa->avgUjian = round($ujianNilai, 2);
            $siswa->avgQuiz = round($quizNilai, 2);
            $siswa->avgTotal = $allNilai->count() > 0 ? round($allNilai->avg(), 2) : 0;

            // ⚠️ Kalau relasi presensi siswa belum dibuat, nanti bisa ditambahkan di sini
            $siswa->totalHadir = 0;
            $siswa->totalTerlambat = 0;
            $siswa->totalIzin = 0;
            $siswa->totalSakit = 0;
            $siswa->totalAlpa = 0;
        }

        return view('admin.laporan.show_detail', compact('kelas', 'mapel', 'daftarSiswa'));
    }
}
