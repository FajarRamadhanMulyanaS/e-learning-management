<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiTugasExport; // Pastikan export class ini ada
use Carbon\Carbon;
use App\Models\GuruMapel;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN Auth
use App\Models\Siswa; // <-- TAMBAHKAN Siswa
use App\Models\User; // <-- TAMBAHKAN User


class TugasSiswaController extends Controller
{

    // Method Guru: Menampilkan daftar tugas yang dibuat guru
    public function index()
    {
        // Ambil semua tugas yang dibuat oleh guru yang sedang login
        $tugas = Tugas::with(['mapel', 'kelas'])
                      ->where('guru_id', auth()->id()) // Gunakan auth()->id() lebih singkat
                      ->latest() // Urutkan dari terbaru
                      ->get();

        return view('guru.tugas-siswa.index', compact('tugas')); // Sesuaikan path view
    }

    // Method Guru: Menampilkan form tambah tugas
    public function create()
    {
        // Mengambil data mapel dan kelas dari guru_mapels berdasarkan guru yang sedang login
        $mapels = GuruMapel::with(['mapel', 'kelas'])
                       ->where('user_id', auth()->id())
                       ->get();

        return view('guru.tugas-siswa.create', compact('mapels')); // Sesuaikan path view
    }

    // Method Guru: Menyimpan tugas baru
    public function store(Request $request)
    {
        // Validasi data input termasuk file
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string', // Deskripsi boleh kosong
            'mapel_id' => 'required|integer|exists:mapels,id', // Validasi exists
            'kelas_id' => 'required|integer|exists:kelas,id', // Validasi exists
            'tanggal_pengumpulan' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png|max:5120', // Tambah tipe file & naikkan max size
            'answers_visible_to_others' => 'required|boolean',
        ]);

        try {
            $filePath = null;
            if ($request->hasFile('file')) {
                // Simpan file di storage/app/public/tugas_files
                $filePath = $request->file('file')->store('tugas_files', 'public');
            }

            // Simpan data tugas
            Tugas::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'mapel_id' => $request->mapel_id,
                'kelas_id' => $request->kelas_id,
                'guru_id' => auth()->id(),
                'tanggal_pengumpulan' => $request->tanggal_pengumpulan, // Langsung simpan format Y-m-d
                'file' => $filePath,
                'answers_visible_to_others' => $request->answers_visible_to_others,
            ]);

            return redirect()->route('guru.tugas-siswa.index')->with('success', 'Tugas berhasil dibuat');
        } catch (\Exception $e) {
             \Log::error('Error saat guru menyimpan tugas: '.$e->getMessage()); // Log error
            return redirect()->back()->with('error', 'Gagal menyimpan tugas. Silakan coba lagi.')->withInput();
        }
    }

    // Method Guru: Menampilkan form edit tugas
    public function edit($id)
    {
        // Mengambil tugas berdasarkan ID, pastikan milik guru yg login
        $tugas = Tugas::where('guru_id', auth()->id())->findOrFail($id);

        // Mengambil data mapel dan kelas untuk dropdown
        $mapels = GuruMapel::with(['mapel', 'kelas'])
                        ->where('user_id', auth()->id())
                        ->get();

        return view('guru.tugas-siswa.edit', compact('tugas', 'mapels')); // Sesuaikan path view
    }

    // Method Guru: Update tugas
    public function update(Request $request, $id)
    {
         // Mengambil tugas berdasarkan ID, pastikan milik guru yg login
        $tugas = Tugas::where('guru_id', auth()->id())->findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mapel_id' => 'required|integer|exists:mapels,id',
            'kelas_id' => 'required|integer|exists:kelas,id',
            'tanggal_pengumpulan' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png|max:5120',
            'answers_visible_to_others' => 'required|boolean',
        ]);

        try {
            $filePath = $tugas->file; // Default pakai file lama
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                // Simpan file baru
                $filePath = $request->file('file')->store('tugas_files', 'public');
            }

            // Update data tugas
            $tugas->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'mapel_id' => $request->mapel_id,
                'kelas_id' => $request->kelas_id,
                'tanggal_pengumpulan' => $request->tanggal_pengumpulan,
                'file' => $filePath,
                'answers_visible_to_others' => $request->answers_visible_to_others,
            ]);

            return redirect()->route('guru.tugas-siswa.index')->with('success', 'Tugas berhasil diperbarui');
        } catch (\Exception $e) {
             \Log::error('Error saat guru update tugas: '.$e->getMessage()); // Log error
            return redirect()->back()->with('error', 'Gagal memperbarui tugas. Silakan coba lagi.')->withInput();
        }
    }

    // Method Guru: Hapus tugas
    public function destroy($id)
    {
        try {
            // Cari tugas berdasarkan ID, pastikan milik guru yg login
            $tugas = Tugas::where('guru_id', auth()->id())->findOrFail($id);

            // Hapus file jika ada
            if ($tugas->file && Storage::disk('public')->exists($tugas->file)) {
                 Storage::disk('public')->delete($tugas->file);
            }

            // Hapus tugas (pengumpulan terkait akan terhapus otomatis jika ada constraint cascade)
            $tugas->delete();

            return redirect()->route('guru.tugas-siswa.index')->with('success', 'Tugas berhasil dihapus');
        } catch (\Exception $e) {
             \Log::error('Error saat guru hapus tugas: '.$e->getMessage()); // Log error
            return redirect()->back()->with('error', 'Gagal menghapus tugas: ' . $e->getMessage());
        }
    }

    // Method Guru: Menampilkan detail tugas dan pengumpulan siswa
    /**
     * !! METHOD INI DIPERBAIKI !!
     * Menambahkan Eager Loading siswa.user
     */
    public function showTugas($id)
    {
        $guruUserId = Auth::id();

        // 1. Ambil data Tugas, pastikan tugas ini milik guru yg login
        $tugas = Tugas::where('guru_id', $guruUserId)
                      ->with(['mapel', 'kelas', 'guru']) // Eager load detail tugas
                      ->findOrFail($id);

        // 2. Ambil data Pengumpulan Tugas untuk tugas ini
        //    !! EAGER LOAD RELASI SISWA DAN USER-NYA !!
        $pengumpulanTugas = PengumpulanTugas::where('tugas_id', $tugas->id)
            ->with([
                'siswa',        // Load relasi ke Siswa
                'siswa.user'    // Load relasi User DARI Siswa
            ])
             ->orderBy('created_at', 'desc') // Urutkan pengumpulan terbaru di atas
            ->get();

        // 3. Kirim data ke view
        return view('guru.tugas-siswa.showguru', compact('tugas', 'pengumpulanTugas')); // Sesuaikan path view
    }


    // Method Guru: Koreksi nilai pengumpulan tugas
    public function koreksiTugas(Request $request, $pengumpulan_id) // Ganti $id jadi $pengumpulan_id agar jelas
    {
        // Validasi input nilai
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        try {
             // Mengambil data pengumpulan tugas, pastikan tugasnya milik guru yg login
            $pengumpulanTugas = PengumpulanTugas::whereHas('tugas', function ($query) {
                $query->where('guru_id', auth()->id());
            })->findOrFail($pengumpulan_id);

            // Update nilai
            $pengumpulanTugas->nilai = $request->input('nilai');
            $pengumpulanTugas->save();

            return redirect()->back()->with('success', 'Nilai berhasil disimpan/diperbarui.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             return redirect()->back()->with('error', 'Pengumpulan tugas tidak ditemukan atau Anda tidak berhak mengoreksi.');
        } catch (\Exception $e) {
             \Log::error('Error saat guru koreksi tugas: '.$e->getMessage());
             return redirect()->back()->with('error', 'Gagal menyimpan nilai.');
        }
    }

    // Method Guru: Export nilai tugas ke Excel
    public function exportExcel($id) // Menerima ID Tugas
    {
         // Pastikan tugas ini milik guru yg login
        $tugas = Tugas::where('guru_id', auth()->id())->find($id);
        if(!$tugas) {
            return redirect()->back()->with('error', 'Tugas tidak ditemukan atau Anda tidak berhak.');
        }

        // Generate nama file dinamis
        $namaFile = 'nilai_tugas_' . \Str::slug($tugas->judul) . '_' . now()->format('Ymd') . '.xlsx';

        // Lakukan export, kirim ID tugas ke class Export
        return Excel::download(new NilaiTugasExport($id), $namaFile);
    }


// ====================================================================================================================
// ========================== METHOD UNTUK SISWA ======================================================================
// ====================================================================================================================

    // Method Siswa: Menampilkan daftar tugas untuk siswa
    public function indexSiswa(Request $request)
    {
        // Ambil siswa yang sedang login beserta kelasnya
        $siswa = Siswa::with('kelas')->where('user_id', auth()->id())->first();
        if(!$siswa || !$siswa->kelas_id) {
             return view('siswa.tugas.index', ['tugas' => collect()])->with('error', 'Anda belum terdaftar di kelas manapun.');
        }
        $kelasId = $siswa->kelas_id;
        $siswaId = $siswa->id; // Gunakan ID dari tabel siswa

        // Ambil tugas untuk kelas siswa tersebut
        $tugasQuery = Tugas::where('kelas_id', $kelasId)
                        ->with(['mapel', 'pengumpulanTugas' => function($query) use ($siswaId) {
                            $query->where('siswa_id', $siswaId); // Filter pengumpulan milik siswa ini
                        }])
                        ->latest('tanggal_pengumpulan'); // Urutkan berdasarkan deadline

        $tugas = $tugasQuery->get();

        // Tambahkan status untuk setiap tugas
        $tugas->each(function($tugasItem) {
            $tugasItem->status = $this->getTugasStatus($tugasItem);
        });

        return view('siswa.tugas.index', compact('tugas')); // Sesuaikan path view
    }

    // Helper method untuk status tugas siswa (private)
    private function getTugasStatus($tugas)
    {
        $now = now();
        $deadline = Carbon::parse($tugas->tanggal_pengumpulan)->endOfDay(); // Deadline di akhir hari
        $isSubmitted = $tugas->pengumpulanTugas->isNotEmpty(); // Cek apakah ada pengumpulan

        if ($isSubmitted) {
            return 'submitted'; // Sudah disubmit
        } elseif ($now->gt($deadline)) {
            return 'overdue'; // Melebihi deadline
        } else {
            return 'pending'; // Belum disubmit dan belum deadline
        }
    }

    // =========================================================================
    // !! METHOD INI TELAH DIPERBAIKI !!
    // =========================================================================
    // Method Siswa: Menampilkan detail tugas
    public function show($id)
    {
        $tugas = Tugas::with('mapel', 'guru', 'kelas')->findOrFail($id);
        $siswaId = Siswa::where('user_id', auth()->id())->value('id'); // Dapatkan siswa_id

        // Ambil pengumpulan tugas milik siswa ini untuk tugas ini
        $pengumpulanSiswa = PengumpulanTugas::where('tugas_id', $id)
                                          ->where('siswa_id', $siswaId)
                                          ->first(); // Hanya ambil satu (jika ada)

        // ---------------------------------------------------------------
        // PERBAIKAN DIMULAI DI SINI
        // ---------------------------------------------------------------
        
        // 1. Buat variabel $pengumpulanTugas yang diharapkan oleh view
        $pengumpulanTugas = collect(); // Mulai dengan koleksi kosong

        // 2. Selalu tambahkan pengumpulan milik siswa sendiri (jika ada)
        if ($pengumpulanSiswa) {
            // Kita perlu load relasi siswa.user di sini agar namanya tampil
            $pengumpulanSiswa->load('siswa.user'); 
            $pengumpulanTugas->push($pengumpulanSiswa);
        }

        // 3. Logika Kondisional untuk Menampilkan Jawaban Siswa Lain
        // (Hanya tampil jika visible & siswa sudah submit)
        if ($tugas->answers_visible_to_others && $pengumpulanSiswa) {
            
            // Ambil semua pengumpulan KECUALI milik siswa ini
            $pengumpulanLain = PengumpulanTugas::with('siswa.user') // Load nama siswa
                                    ->where('tugas_id', $id)
                                    ->where('siswa_id', '!=', $siswaId)
                                    ->get();
            
            // 4. Gabungkan koleksi $pengumpulanSiswa dengan $pengumpulanLain
            $pengumpulanTugas = $pengumpulanTugas->merge($pengumpulanLain);
        }

        // 5. Kirim variabel yang benar ke view
        //    ($pengumpulanSiswa untuk cek tombol submit/edit)
        //    ($pengumpulanTugas untuk tabel loop)
        //    ($siswaId untuk perbaikan bug di tombol edit/hapus)
        return view('siswa.tugas.show', compact('tugas', 'pengumpulanSiswa', 'pengumpulanTugas', 'siswaId')); 
        
        // ---------------------------------------------------------------
        // PERBAIKAN SELESAI
        // ---------------------------------------------------------------
    }

     // Method Siswa: Menampilkan form pengumpulan tugas
     public function formPengumpulan($id)
     {
        $tugas = Tugas::findOrFail($id);
        $siswaId = Siswa::where('user_id', auth()->id())->value('id');

        // Cek apakah sudah pernah mengumpulkan
        $existingSubmission = PengumpulanTugas::where('tugas_id', $id)->where('siswa_id', $siswaId)->first();
        if($existingSubmission){
            // Jika sudah, redirect ke halaman edit
             return redirect()->route('siswa.tugas.edit', $existingSubmission->id);
        }

        // Cek deadline sebelum menampilkan form submit baru
        $deadline = Carbon::parse($tugas->tanggal_pengumpulan)->endOfDay();
        if (now()->gt($deadline)) {
             return redirect()->route('siswa.tugas.show', $id)->with('error', 'Waktu pengumpulan tugas sudah berakhir.');
        }

        return view('siswa.tugas.submit', compact('tugas')); // Sesuaikan path view
     }

    // Method Siswa: Menyimpan tugas yang dikumpulkan
    public function submitTugas(Request $request, $id) // Menerima ID Tugas
    {
        $tugas = Tugas::findOrFail($id);
        $siswaId = Siswa::where('user_id', auth()->id())->value('id');

         // Cek deadline sebelum submit
        $deadline = Carbon::parse($tugas->tanggal_pengumpulan)->endOfDay();
        if (now()->gt($deadline)) {
             return redirect()->route('siswa.tugas.show', $id)->with('error', 'Waktu pengumpulan tugas sudah berakhir.');
        }

        // Cek apakah sudah pernah mengumpulkan
        $existingSubmission = PengumpulanTugas::where('tugas_id', $id)->where('siswa_id', $siswaId)->first();
        if($existingSubmission){
             return redirect()->route('siswa.tugas.show', $id)->with('error', 'Anda sudah mengumpulkan tugas ini.');
        }


        $request->validate([
            'file_pengumpulan' => 'required|file|mimes:pdf,doc,docx,jpg,png,jpeg,zip,rar|max:5120', // Tambah zip/rar, naikkan max size
             'komentar' => 'nullable|string|max:500',
        ]);

        try {
            // Simpan file tugas ke storage/app/public/tugas_pengumpulan
            $filePath = $request->file('file_pengumpulan')->store('tugas_pengumpulan', 'public');

            // Simpan data ke database
            PengumpulanTugas::create([
                'tugas_id' => $id,
                'siswa_id' => $siswaId, // Gunakan ID dari tabel siswa
                'file_tugas' => $filePath, // Nama kolom harus 'file_tugas'
                'komentar' => $request->komentar,
            ]);

            return redirect()->route('siswa.tugas.show', $id)->with('success', 'Tugas berhasil dikumpulkan.');

         } catch (\Exception $e) {
             \Log::error('Error saat siswa submit tugas: '.$e->getMessage());
             return redirect()->back()->with('error', 'Gagal mengumpulkan tugas. Silakan coba lagi.')->withInput();
         }
    }

    // Method Siswa: Menampilkan form edit pengumpulan
    public function formEditPengumpulan($pengumpulan_id) // Menerima ID Pengumpulan
    {
        $pengumpulan = PengumpulanTugas::where('siswa_id', Siswa::where('user_id', auth()->id())->value('id'))
                                       ->findOrFail($pengumpulan_id);
        $tugas = $pengumpulan->tugas; // Ambil data tugas dari relasi

         // Cek deadline sebelum edit
        $deadline = Carbon::parse($tugas->tanggal_pengumpulan)->endOfDay();
        if (now()->gt($deadline) && $pengumpulan->nilai === null) { // Boleh edit jika sudah dinilai? Sesuaikan logikanya
             return redirect()->route('siswa.tugas.show', $tugas->id)->with('error', 'Waktu pengumpulan tugas sudah berakhir, Anda tidak dapat mengedit.');
        }

        return view('siswa.tugas.edit', compact('pengumpulan', 'tugas')); // Sesuaikan path view
    }

    // Method Siswa: Update pengumpulan tugas
    public function updateTugasSiswa(Request $request, $pengumpulan_id) // Menerima ID Pengumpulan
    {
        $siswaId = Siswa::where('user_id', auth()->id())->value('id');
        $pengumpulan = PengumpulanTugas::where('siswa_id', $siswaId)
                                       ->findOrFail($pengumpulan_id);
        $tugas = $pengumpulan->tugas;

        // Cek deadline sebelum update
        $deadline = Carbon::parse($tugas->tanggal_pengumpulan)->endOfDay();
         if (now()->gt($deadline) && $pengumpulan->nilai === null) { // Logika sama seperti formEdit
             return redirect()->route('siswa.tugas.show', $tugas->id)->with('error', 'Waktu pengumpulan tugas sudah berakhir, Anda tidak dapat mengedit.');
        }

        $request->validate([
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar|max:5120',
            'komentar' => 'nullable|string|max:500',
        ]);

        try {
            $filePath = $pengumpulan->file_tugas; // Default pakai file lama
            if ($request->hasFile('file_tugas')) {
                // Hapus file lama jika ada
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                // Simpan file baru
                $filePath = $request->file('file_tugas')->store('tugas_pengumpulan', 'public');
            }

            // Update data
            $pengumpulan->update([
                'file_tugas' => $filePath,
                'komentar' => $request->komentar ?? $pengumpulan->komentar, // Update komentar jika diisi
            ]);

            return redirect()->route('siswa.tugas.show', $pengumpulan->tugas_id)
                             ->with('success', 'Pengumpulan tugas berhasil diperbarui.');

        } catch (\Exception $e) {
             \Log::error('Error saat siswa update tugas: '.$e->getMessage());
             return redirect()->back()->with('error', 'Gagal memperbarui pengumpulan tugas.')->withInput();
        }
    }

    // Method Siswa: Menghapus pengumpulan tugas
    public function destroyTugasSiswa($pengumpulan_id) // Menerima ID Pengumpulan
    {
        try {
            $siswaId = Siswa::where('user_id', auth()->id())->value('id');
            $pengumpulan = PengumpulanTugas::where('siswa_id', $siswaId)
                                       ->findOrFail($pengumpulan_id);
            $tugasId = $pengumpulan->tugas_id; // Simpan ID tugas untuk redirect

             // Cek deadline sebelum hapus (opsional, mungkin siswa boleh hapus kapan saja sebelum dinilai?)
            // $deadline = Carbon::parse($pengumpulan->tugas->tanggal_pengumpulan)->endOfDay();
            // if (now()->gt($deadline) && $pengumpulan->nilai === null) {
            //      return redirect()->route('siswa.tugas.show', $tugasId)->with('error', 'Waktu pengumpulan tugas sudah berakhir.');
            // }
            // if ($pengumpulan->nilai !== null) {
            //      return redirect()->route('siswa.tugas.show', $tugasId)->with('error', 'Tidak dapat menghapus tugas yang sudah dinilai.');
            // }


            // Hapus file tugas jika ada
            if ($pengumpulan->file_tugas && Storage::disk('public')->exists($pengumpulan->file_tugas)) {
                Storage::disk('public')->delete($pengumpulan->file_tugas);
            }

            $pengumpulan->delete();

            return redirect()->route('siswa.tugas.show', $tugasId)
                             ->with('success', 'Pengumpulan tugas berhasil dihapus.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             return redirect()->route('siswa.tugas.index')->with('error', 'Pengumpulan tugas tidak ditemukan.'); // Redirect ke index jika tidak ketemu
        } catch (\Exception $e) {
             \Log::error('Error saat siswa hapus tugas: '.$e->getMessage());
             return redirect()->back()->with('error', 'Gagal menghapus pengumpulan tugas.');
        }
    }
}