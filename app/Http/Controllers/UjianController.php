<?php

namespace App\Http\Controllers;

use DB;
use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Ujian;
use App\Models\User;
use App\Models\Siswa;
use App\Models\HasilUjian;
use App\Models\PilihanGanda;
use App\Models\Essay;
use App\Models\JawabanSiswaPilgan;
use App\Models\JawabanSiswaEssay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan auth untuk mengambil siswa

class UjianController extends Controller
{
    public function index()
    {
        // Ambil ID kelas dari siswa yang sedang login
        $kelasId = Auth::user()->siswa->kelas_id;

        // Ambil ujian yang sesuai dengan kelas siswa
        $ujians = Ujian::where('kelas_id', $kelasId)
            ->with(['mapel', 'user'])
            ->get();

        return view('siswa.ujian.index', compact('ujians'));
    }

    public function view($id)
    {
        // Mengambil detail ujian berdasarkan ID
        $ujian = Ujian::with(['user', 'mapel']) // Menambahkan mapel juga
            ->find($id);

        if (!$ujian) {
            return redirect()->route('siswa.ujian.index')->with('error', 'Ujian tidak ditemukan.');
        }

        // Mengambil data siswa yang sedang login
        $siswa = Auth::user()->siswa;

        return view('siswa.ujian.view', compact('ujian', 'siswa'));
    }

    public function kerjakan($id)
    {
        // Mengambil detail ujian berdasarkan ID dengan relasi user dan mapel
        $ujian = Ujian::with(['user', 'mapel'])->findOrFail($id);

        // Mengambil data siswa yang sedang login
        $siswa = Auth::user()->siswa;

        return view('siswa.ujian.kerjakan', compact('ujian', 'siswa'));
    }

    public function mulaiPilgan($id)
    {
        // Mengambil detail ujian dan soal pilihan ganda yang terkait dengan ujian
        $ujian = Ujian::with('pilihanGanda')->findOrFail($id);

        // Mengambil soal-soal pilihan ganda terkait ujian
        $soals = $ujian->pilihanGanda;

        // Mengambil data siswa yang sedang login
        $siswa = Auth::user()->siswa;

        return view('siswa.ujian.mulai.pilgan', compact('ujian', 'soals', 'siswa'));
    }

    public function submitPilgan(Request $request, $id)
    {
        // Ambil detail ujian
        $ujian = Ujian::findOrFail($id);

        // Ambil id siswa dari session atau model
        $siswaId = auth()->user()->siswa->id;

        // Ambil jawaban dari form
        $jawabanSiswa = $request->input('kunci_jawaban'); // format: ['soal_id' => 'jawaban']

        // Inisialisasi variabel untuk menghitung nilai
        $jumlahBenar = 0;
        $totalSoal = count($jawabanSiswa); // Total soal yang dijawab

        // Loop setiap jawaban untuk menyimpan dan mengecek kebenaran
        foreach ($jawabanSiswa as $soalId => $jawaban) {
            $soal = PilihanGanda::findOrFail($soalId); // Ambil soal pilihan ganda berdasarkan ID

            // Cek apakah jawaban siswa untuk soal ini sudah ada
            $existingJawaban = JawabanSiswaPilgan::where('siswa_id', $siswaId)
                ->where('ujian_id', $ujian->id)
                ->where('pilihan_ganda_id', $soalId)
                ->first();

            if ($existingJawaban) {
                // Update jawaban jika sudah ada
                $existingJawaban->update([
                    'jawaban_siswa' => $jawaban,
                    'updated_at' => now()
                ]);
            } else {
                // Insert jawaban baru jika belum ada
                JawabanSiswaPilgan::create([
                    'siswa_id' => $siswaId,
                    'ujian_id' => $ujian->id,
                    'pilihan_ganda_id' => $soalId,
                    'jawaban_siswa' => $jawaban,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Cek apakah jawaban siswa benar
            if ($jawaban == $soal->kunci_jawaban) {
                $jumlahBenar++;
            }
        }

        // Hitung nilai pilihan ganda (nilai_pg)
        $nilai_pg = $totalSoal > 0 ? ($jumlahBenar / $totalSoal) * 100 : 0;

        // Simpan nilai_pg ke tabel jawaban_siswa_pilgan jika diperlukan
        DB::table('jawaban_siswa_pilgan')
            ->where('siswa_id', $siswaId)
            ->where('ujian_id', $ujian->id)
            ->update(['nilai_pg' => $nilai_pg]);

        // Redirect ke halaman hasil ujian dengan pesan sukses
        return redirect()->route('siswa.ujian.nilai.pilgan', $ujian->id)->with('success', 'Jawaban berhasil disimpan.');
    }


    public function hasilUjian($id)
    {
        // Ambil detail ujian beserta soal pilihan ganda
        $ujian = Ujian::with(['pilihanGanda'])->findOrFail($id);

        // Ambil id siswa dari session atau model
        $siswaId = auth()->user()->siswa->id;

        // Ambil jawaban siswa dari database
        $jawabanSiswa = JawabanSiswaPilgan::where('siswa_id', $siswaId)
            ->where('ujian_id', $ujian->id)
            ->pluck('jawaban_siswa', 'pilihan_ganda_id');

        // Inisialisasi variabel untuk menghitung nilai
        $jumlahBenar = 0;

        // Periksa jawaban pilihan ganda
        foreach ($ujian->pilihanGanda as $soal) {
            if (isset($jawabanSiswa[$soal->id]) && $jawabanSiswa[$soal->id] == $soal->kunci_jawaban) {
                $jumlahBenar++;
            }
        }

        // Hitung skor dan bulatkan
        $totalSoal = $ujian->pilihanGanda->count();
        $skor = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100) : 0;

        // Kirim data ke view
        return view('siswa.ujian.nilai.pilgan', compact('ujian', 'jawabanSiswa', 'jumlahBenar', 'totalSoal', 'skor'));
    }


    // ==================================================================================================================
// ==================================================================================================================

    public function tampilEssay($id)
    {
        // Ambil detail ujian berdasarkan ID dengan soal essay yang berelasi
        $ujian = Ujian::with('essay')->findOrFail($id);

        // Ambil semua soal essay terkait ujian
        $soals = $ujian->essay;

        return view('siswa.ujian.mulai.essay', compact('ujian', 'soals'));
    }

    public function submitEssay(Request $request, $id)
    {
        // Validasi jawaban essay
        $request->validate([
            'jawaban' => 'required|array', // Jawaban harus dalam format array
            'jawaban.*' => 'required|string', // Setiap jawaban harus berupa string
        ]);

        // Ambil ujian dan id siswa
        $ujian = Ujian::findOrFail($id);
        $siswaId = auth()->user()->siswa->id;

        // Loop dan simpan jawaban siswa ke dalam database
        foreach ($request->jawaban as $soalId => $jawaban) {
            $existingJawaban = JawabanSiswaEssay::where('siswa_id', $siswaId)
                ->where('ujian_id', $ujian->id)
                ->where('essay_id', $soalId)
                ->first();

            if ($existingJawaban) {
                // Update jawaban jika sudah ada
                $existingJawaban->update([
                    'jawaban_siswa' => $jawaban,
                    'updated_at' => now()
                ]);
            } else {
                // Insert jawaban baru jika belum ada
                JawabanSiswaEssay::create([
                    'siswa_id' => $siswaId,
                    'ujian_id' => $ujian->id,
                    'essay_id' => $soalId,
                    'jawaban_siswa' => $jawaban,
                    'nilai_essay' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        return redirect()->route('siswa.ujian.nilai.essay', ['id' => $ujian->id])->with('success', 'Jawaban berhasil disimpan.');
    }

    // Halaman menampilkan Nilai Siswa Essay di halaman siswa
    public function showNilaiEssay($ujian_id)
    {
        // Ambil data ujian dengan soal essay terkait
        $ujian = Ujian::with('essay')->findOrFail($ujian_id);

        // Ambil ID siswa dari sesi atau autentikasi
        $siswaId = Auth::user()->siswa->id;

        // Ambil jawaban essay siswa beserta nilai_essay dari tabel jawaban_siswa_essay
        $jawabanSiswa = JawabanSiswaEssay::where('siswa_id', $siswaId)
            ->where('ujian_id', $ujian->id)
            ->get()
            ->keyBy('essay_id'); // Mengelompokkan berdasarkan essay_id

        // Ambil nilai total essay yang sudah dikoreksi oleh guru dari tabel hasil_ujian
        $hasilUjian = HasilUjian::where('siswa_id', $siswaId)
            ->where('ujian_id', $ujian->id)
            ->first();

        // Jika data hasil ujian ditemukan, ambil total nilai essay dan hitung nilai akhir
        $nilaiTotal = $hasilUjian ? $hasilUjian->total_nilai_essay : 0;
        $jumlahSoal = $ujian->essay->count();



        return view('siswa.ujian.nilai.essay', compact('ujian', 'jawabanSiswa', 'nilaiTotal'));
    }
    // ==================================================================================================================
// ===================================== Koreksi Ujian Siswa =========================================================
// ==================================================================================================================


    public function daftarSiswa($ujian_id)
    {
        // Ambil kelas_id dari ujian yang dipilih
        $kelas_id = DB::table('ujian')->where('id', $ujian_id)->value('kelas_id');

        $siswaSudahUjian = DB::table('siswa')
            ->join('users', 'siswa.user_id', '=', 'users.id') // <-- Diperbaiki
            ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id') // <-- SUDAH DIPERBAIKI
            ->leftJoin('jawaban_siswa_pilgan', function ($join) use ($ujian_id) {   
                $join->on('siswa.id', '=', 'jawaban_siswa_pilgan.siswa_id')
                    ->where('jawaban_siswa_pilgan.ujian_id', $ujian_id);
            })
            ->leftJoin('hasil_ujian', function ($join) use ($ujian_id) {
                $join->on('hasil_ujian.siswa_id', '=', 'siswa.id')
                    ->where('hasil_ujian.ujian_id', $ujian_id);
            })
            ->select(
                'siswa.id as siswa_id',
                'siswa.nisn',
                'siswa.nis',
                'users.username as nama_siswa',
                'kelas.nama_kelas as kelas',  // Nama kelas dari tabel kelas
                'jawaban_siswa_pilgan.nilai_pg',
                'hasil_ujian.total_nilai_essay',
                DB::raw("'$ujian_id' as ujian_id")
            )
            ->where('kelas.id', $kelas_id) // Filter berdasarkan kelas ujian
            ->distinct()
            ->get();

        return view('guru.manajemen-ujian.koreksi.daftar-siswa', compact('siswaSudahUjian', 'ujian_id'));
    }



    // Method untuk menampilkan halaman analisa nilai PG
    public function analisaPilihanGanda($ujian_id, $siswa_id)
    {
        // Ambil data ujian, soal pilihan ganda, dan jawaban siswa
        $ujian = Ujian::with('soal')->findOrFail($ujian_id);

        // Ambil data siswa beserta user dan kelas
        $siswa = Siswa::with('user', 'kelas')->findOrFail($siswa_id);

        // Ambil jawaban pilihan ganda siswa berdasarkan ujian dan siswa
        $jawabanSiswa = JawabanSiswaPilgan::where('ujian_id', $ujian_id)
            ->where('siswa_id', $siswa_id)
            ->get()
            ->keyBy('pilihan_ganda_id'); // Mengindeks berdasarkan pilihan_ganda_id

        $jumlahBenar = 0;
        $jumlahSalah = 0;
        $tidakDijawab = 0;

        // Loop soal untuk analisis jawaban
        foreach ($ujian->soal as $soal) {
            $jawaban = $jawabanSiswa->get($soal->id);

            if ($jawaban) {
                if ($jawaban->jawaban_siswa == $soal->kunci_jawaban) { // Membandingkan jawaban siswa dengan kunci jawaban
                    $soal->jawaban_siswa = $jawaban->jawaban_siswa; // Simpan jawaban siswa
                    $soal->analisa = 'Benar';
                    $jumlahBenar++;
                } else {
                    $soal->jawaban_siswa = $jawaban->jawaban_siswa; // Simpan jawaban siswa
                    $soal->analisa = 'Salah';
                    $jumlahSalah++;
                }
            } else {
                // Jika jawaban tidak ada, beri tanda tidak dijawab
                $soal->jawaban_siswa = 'Tidak Dijawab';
                $soal->analisa = 'Tidak Dijawab';
                $tidakDijawab++;
            }
        }

        // Ambil nama pengguna siswa
        $namaSiswa = $siswa->user->username;

        return view('guru.manajemen-ujian.koreksi.analisa_pg', compact('ujian', 'siswa', 'namaSiswa', 'jumlahBenar', 'jumlahSalah', 'tidakDijawab'));
    }




    // Fungsi tambahan untuk menghitung nilai pilihan ganda
    private function hitungNilaiPG($jawabanPG)
    {
        // Contoh perhitungan sederhana: cocokkan jawaban siswa dengan kunci
        $nilai = 0;
        foreach ($jawabanPG as $jawaban) {
            if ($jawaban->jawaban == $jawaban->soal->kunci_jawaban) {
                $nilai += 1; // Tambah nilai untuk jawaban yang benar
            }
        }
        return $nilai; // Mengembalikan total nilai PG
    }


    // ==================================================================================================================
// ===================================== Koreksi Ujian Siswa Essay =========================================================
// ==================================================================================================================


    // Method untuk menampilkan halaman koreksi essay
    public function koreksiEssay($ujian_id, $siswa_id)
    {
        $ujian = Ujian::findOrFail($ujian_id);
        $siswa = Siswa::findOrFail($siswa_id);

        // Ambil jawaban essay siswa
        $jawabanEssay = JawabanSiswaEssay::where('ujian_id', $ujian_id)
            ->where('siswa_id', $siswa_id)
            ->first();

        return view('guru.manajemen-ujian.koreksi.koreksi_essay', compact('ujian', 'siswa', 'jawabanEssay'));
    }


    // Method untuk melakukan update nilai essay setelah dikoreksi
    public function simpanKoreksiEssay(Request $request, $ujian_id, $siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);

        // Validasi nilai essay yang dikoreksi
        $request->validate([
            'nilai_essay' => 'required|numeric|min:0|max:100',
        ]);

        // Simpan nilai essay yang telah dikoreksi
        $jawabanEssay = JawabanSiswaEssay::where('ujian_id', $ujian_id)
            ->where('siswa_id', $siswa_id)
            ->first();
        $jawabanEssay->nilai_essay = $request->input('nilai_essay');
        $jawabanEssay->save();

        return redirect()->route('guru.manajemen-ujian.koreksi.daftar-siswa', $ujian_id)
            ->with('success', 'Nilai Essay berhasil disimpan.');
    }

    public function exportExcel($ujian_id)
    {
        // Ambil kelas_id dari ujian yang dipilih
        $kelas_id = DB::table('ujian')->where('id', $ujian_id)->value('kelas_id');

        // Ambil data siswa yang sudah mengikuti ujian
        $siswaSudahUjian = DB::table('siswa')
            ->join('users', 'siswa.user_id', '=', 'users.id') // <-- Diperbaiki
            ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id') // <-- SUDAH DIPERBAIKI
            ->leftJoin('jawaban_siswa_pilgan', function ($join) use ($ujian_id) {
                $join->on('siswa.id', '=', 'jawaban_siswa_pilgan.siswa_id')
                    ->where('jawaban_siswa_pilgan.ujian_id', $ujian_id);
            })
            ->leftJoin('hasil_ujian', function ($join) use ($ujian_id) {
                $join->on('hasil_ujian.siswa_id', '=', 'siswa.id')
                    ->where('hasil_ujian.ujian_id', $ujian_id);
            })
            ->select(
                'siswa.nis',
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
        return Excel::download(new SiswaExport($siswaSudahUjian), 'daftar_Pelajar_ujian.xlsx');
    }


}
