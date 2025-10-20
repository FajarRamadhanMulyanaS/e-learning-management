<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiTugasExport;
use Carbon\Carbon;
use App\Models\GuruMapel;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasSiswaController extends Controller
{

    public function index()
    {
        // Ambil semua tugas yang dibuat oleh guru yang sedang login
        $tugas = Tugas::with(['mapel', 'kelas'])
                    ->where('guru_id', auth()->id())
                    ->get();

        return view('guru.tugas-siswa.index', compact('tugas'));
    }


    public function create()
    {

        // Mengambil data mapel dan kelas dari guru_mapels berdasarkan guru yang sedang login
        $mapels = GuruMapel::with(['mapel', 'kelas'])
                    ->where('user_id', auth()->id())
                    ->get();

        return view('guru.tugas-siswa.create', compact('mapels'));
    }


    public function store(Request $request)
    {
        // Validasi data input termasuk file
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'mapel_id' => 'required|integer',
            'kelas_id' => 'required|integer',
            'tanggal_pengumpulan' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        try {
            // Simpan file jika ada
            $filePath = null;
            if ($request->hasFile('file')) {
                try {
                    $filePath = $request->file('file')->store('tugas_files', 'public');
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Gagal mengunggah file: ' . $e->getMessage());
                }
            }

            // Pastikan tanggal_pengumpulan diformat dengan benar
            $tanggalPengumpulan = Carbon::createFromFormat('Y-m-d', $request->tanggal_pengumpulan)->format('Y-m-d');

            // Simpan data tugas
            Tugas::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'mapel_id' => $request->mapel_id,
                'kelas_id' => $request->kelas_id,
                'guru_id' => auth()->id(),
                'tanggal_pengumpulan' => $tanggalPengumpulan,
                'file' => $filePath,
            ]);

            return redirect()->route('guru.tugas-siswa.index')->with('success', 'Tugas berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan tugas. Silakan coba lagi.');
        }
    }


    public function edit($id)
    {
        // Mengambil tugas berdasarkan ID
        $tugas = Tugas::findOrFail($id);

        // Mengambil data mapel dan kelas dari guru_mapels berdasarkan guru yang sedang login
        $mapels = GuruMapel::with(['mapel', 'kelas'])
                            ->where('user_id', auth()->id())
                            ->get();

        return view('guru.tugas-siswa.edit', compact('tugas', 'mapels'));
    }

    // =================================================================================================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'mapel_id' => 'required|integer',
            'kelas_id' => 'required|integer',
            'tanggal_pengumpulan' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $tugas = Tugas::findOrFail($id);

        try {
            // Handle file update if necessary
            $filePath = $tugas->file;
            if ($request->hasFile('file')) {
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $filePath = $request->file('file')->store('tugas_files', 'public');
            }

            // Update tugas data
            $tugas->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'mapel_id' => $request->mapel_id,
                'kelas_id' => $request->kelas_id,
                'tanggal_pengumpulan' => date_create_from_format('Y-m-d', $request->tanggal_pengumpulan),
                'file' => $filePath,
            ]);

            return redirect()->route('guru.tugas-siswa.index')->with('success', 'Tugas berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui tugas. Silakan coba lagi.');
        }
    }

// =================================================================================================================

        public function destroy($id)
    {
        try {
            // Cari tugas berdasarkan ID
            $tugas = Tugas::findOrFail($id);

            // Hapus file jika ada
            if ($tugas->file) {
                Storage::disk('public')->delete($tugas->file);
            }

            // Hapus tugas
            $tugas->delete();

            return redirect()->route('guru.tugas-siswa.index')->with('success', 'Tugas berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus tugas: ' . $e->getMessage());
        }
    }

// =================================================================================================================

    // di Halaman Guru
    public function showTugas($id)
    {
        // Mengambil data tugas berdasarkan ID
        $tugas = Tugas::with(['mapel', 'kelas', 'guru'])->findOrFail($id);

        // Mengambil data pengumpulan tugas siswa berdasarkan tugas_id
        $pengumpulanTugas = PengumpulanTugas::where('tugas_id', $id)->with(['siswa'])->get();

        return view('guru.tugas-siswa.showguru', compact('tugas', 'pengumpulanTugas'));
    }

    public function koreksiTugas(Request $request, $id)
{
    // Validasi input nilai
    $request->validate([
        'nilai' => 'required|numeric|min:0|max:100',
    ]);

    // Mengambil data pengumpulan tugas berdasarkan ID
    $pengumpulanTugas = PengumpulanTugas::findOrFail($id);

    // Periksa apakah nilai sudah ada dan berikan opsi koreksi
    if ($pengumpulanTugas->nilai !== null) {
        $pengumpulanTugas->nilai = $request->input('nilai');
        $pesan = 'Nilai diperbarui berhasil!';
    } else {
        $pengumpulanTugas->nilai = $request->input('nilai');
        $pesan = 'Nilai disimpan berhasil!';
    }

    $pengumpulanTugas->save();

    return redirect()->back()->with('success', $pesan);
}



// ====================================================================================================================
// ====================================================================================================================

    public function indexSiswa(Request $request)
    {
        $kelasId = auth()->user()->kelas_id;
        $siswaId = auth()->id();
        
        $tugas = Tugas::where('kelas_id', $kelasId)
                    ->with(['mapel', 'pengumpulanTugas' => function($query) use ($siswaId) {
                        $query->where('siswa_id', $siswaId);
                    }])
                    ->get();

        // Tambahkan status untuk setiap tugas
        $tugas->each(function($tugasItem) {
            $tugasItem->status = $this->getTugasStatus($tugasItem);
        });

        return view('siswa.tugas.index', compact('tugas'));
    }

    private function getTugasStatus($tugas)
    {
        $now = now();
        $deadline = $tugas->tanggal_pengumpulan;
        $isSubmitted = $tugas->pengumpulanTugas->isNotEmpty();
        
        if ($isSubmitted) {
            return 'submitted'; // Sudah disubmit
        } elseif ($now->gt($deadline)) {
            return 'overdue'; // Melebihi deadline
        } else {
            return 'pending'; // Belum disubmit dan belum deadline
        }
    }

    public function show($id)
    {
        $tugas = Tugas::with('mapel', 'guru', 'kelas')->findOrFail($id);
        $pengumpulanTugas = PengumpulanTugas::with('siswa')->where('tugas_id', $id)->get();

        return view('siswa.tugas.show', compact('tugas', 'pengumpulanTugas'));
    }

     // Menampilkan form pengumpulan tugas
     public function formPengumpulan($id)
     {
         $tugas = Tugas::findOrFail($id); // Pastikan id tugas valid
         return view('siswa.tugas.submit', compact('tugas'));
     }

    // Menyimpan tugas yang dikumpulkan siswa
    public function submitTugas(Request $request, $id)
    {
        $request->validate([
            'file_pengumpulan' => 'required|mimes:pdf,doc,docx,jpg,png,jpeg|max:2048',
        ]);

        // Simpan file tugas ke penyimpanan
        $file = $request->file('file_pengumpulan')->store('tugas_pengumpulan');

        // Simpan data ke database
        PengumpulanTugas::create([
            'tugas_id' => $id,
            'siswa_id' => auth()->id(),
            'file_tugas' => $file, // Pastikan 'file_tugas' disertakan
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('siswa.tugas.show', $id)->with('success', 'Tugas berhasil dikumpulkan.');
    }

    // tampilan halaman pengumpulan di siswa
    public function formEditPengumpulan($id)
    {
        $pengumpulan = PengumpulanTugas::findOrFail($id); // Mengambil data pengumpulan tugas
        $tugas = Tugas::findOrFail($pengumpulan->tugas_id); // Mengambil data tugas terkait

        return view('siswa.tugas.edit', compact('pengumpulan', 'tugas'));
    }

    // Update pengumpulan tugas halaman siswa
    public function updateTugasSiswa(Request $request, $id)
    {
        $pengumpulan = PengumpulanTugas::findOrFail($id);

        $request->validate([
            'file_tugas' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048', // Validasi file
            'komentar' => 'nullable|string|max:255', // Validasi komentar
        ]);

        // Jika ada file yang diupload, simpan file baru dan hapus file lama
        if ($request->hasFile('file_tugas')) {
            // Hapus file lama
            if ($pengumpulan->file_tugas) {
                Storage::delete($pengumpulan->file_tugas);
            }

            // Simpan file baru
            $file = $request->file('file_tugas')->store('tugas_pengumpulan');
            $pengumpulan->file_tugas = $file;
        }

        // Update komentar jika ada
        $pengumpulan->komentar = $request->komentar ?? $pengumpulan->komentar;

        $pengumpulan->save();

        return redirect()->route('siswa.tugas.show', $pengumpulan->tugas_id)
                        ->with('success', 'Pengumpulan tugas berhasil diupdate.');
    }

    // Menghapus pengumpulan tugas
    public function destroyTugasSiswa($id)
    {
        $pengumpulan = PengumpulanTugas::findOrFail($id);

        // Hapus file tugas jika ada
        if ($pengumpulan->file_tugas) {
            Storage::delete($pengumpulan->file_tugas);
        }

        $pengumpulan->delete();

        return redirect()->route('siswa.tugas.show', $pengumpulan->tugas_id)
                        ->with('success', 'Pengumpulan tugas berhasil dihapus.');
    }



// ====================================================================================================================
// ====================================================================================================================

public function exportExcel($id)
{
    return Excel::download(new NilaiTugasExport($id), 'nilai_tugas.xlsx');
}

}
