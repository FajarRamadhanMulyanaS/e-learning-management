<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Mapel; // Model untuk Mata Pelajaran
use App\Models\GuruMapel; // Model untuk Mata Pelajaran
use App\Models\Kelas; // Model untuk Kelas
class MateriController extends Controller
{
    //
    public function index()
{
    // Ambil data materi yang dibuat oleh guru yang sedang login
    $materi = Materi::with(['mapel', 'kelas'])
                ->where('user_id', auth()->id()) // Hanya untuk guru yang sedang login
                ->get();

    // Ambil data mapel dan kelas sesuai guru yang sedang login
    $mapels = GuruMapel::where('user_id', auth()->id())
                ->with(['mapel', 'kelas'])
                ->get();

    return view('guru.materi.index', compact('materi', 'mapels'));
}



public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'judul' => 'required|string|max:255',
        'mapel_id' => 'required|integer',
        'kelas_id' => 'required|integer',
        'file' => 'required|file|mimes:pdf,doc,docx|max:2048', // Maksimal 2MB
    ]);

    // Proses upload file
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads/materi', $fileName, 'public');

        // Cek jika proses upload gagal
        if (!$filePath) {
            return redirect()->back()->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
        }
    } else {
        return redirect()->back()->with('error', 'File tidak ditemukan atau format tidak sesuai.');
    }

    // Simpan data ke database
    $materi = new Materi();
    $materi->judul = $request->input('judul');
    $materi->mapel_id = $request->input('mapel_id');
    $materi->kelas_id = $request->input('kelas_id');
    $materi->file_path = $filePath;
    $materi->user_id = Auth::id();
    $materi->save();

    return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil ditambahkan.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'mapel_id' => 'required|integer',
        'kelas_id' => 'required|integer',
        'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ]);

    $materi = Materi::findOrFail($id);

    $materi->judul = $request->judul;
    $materi->mapel_id = $request->mapel_id;
    $materi->kelas_id = $request->kelas_id;

    if ($request->hasFile('file')) {
        // Hapus file lama jika ada
        if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
            Storage::disk('public')->delete($materi->file_path);
        }

        $filePath = $request->file('file')->store('materi_files', 'public');

        // Cek jika proses upload gagal
        if (!$filePath) {
            return redirect()->back()->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
        }

        $materi->file_path = $filePath;
    }

    $materi->save();

    return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diperbarui');
}



    // Fungsi untuk menghapus data materi
    public function destroy($id)
    {
        // Temukan data materi berdasarkan ID
        $materi = Materi::findOrFail($id);

        // Hapus file yang terkait jika ada
        if ($materi->file_path && Storage::exists($materi->file_path)) {
            Storage::delete($materi->file_path);
        }

        // Hapus data materi dari database
        $materi->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil dihapus.');
    }



    // tampilan materi untuk siswa
    public function indexSiswa()
    {
        // Ambil kelas_id dari user yang sedang login
        $kelasId = Auth::user()->kelas_id;

        // Ambil materi sesuai kelas_id
        $materi = Materi::with(['mapel', 'user'])
                    ->where('kelas_id', $kelasId)
                    ->paginate(10);

        return view('siswa.materi.index', compact('materi'));
    }

    // Detail untuk materi Siswa
    public function detailMateri($id)
    {
        // Ambil kelas_id dari user yang sedang login
        $kelasId = Auth::user()->kelas_id;

        // Ambil materi sesuai id dan kelas_id
        $materi = Materi::with(['mapel', 'user'])
                    ->where('kelas_id', $kelasId)
                    ->where('id', $id)
                    ->first();  // Mengambil satu record

        // Pastikan materi ditemukan, jika tidak kembalikan ke halaman sebelumnya
        if (!$materi) {
            return redirect()->back()->with('error', 'Materi tidak ditemukan.');
        }

        return view('siswa.materi.detail', compact('materi'));
    }


}
