<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\GuruMapel;
use Illuminate\Support\Facades\Auth;
class VideoController extends Controller
{
    // Menampilkan halaman manajemen video
    public function index()
{
    $userId = auth()->user()->id; // ID user yang login

    // Ambil mata pelajaran yang diampu oleh guru
    $mapel = GuruMapel::where('user_id', $userId)
            ->join('mapels', 'guru_mapels.mapel_id', '=', 'mapels.id')
            ->select('mapels.id', 'mapels.nama_mapel')
            ->distinct()
            ->get();

    // Ambil kelas yang diampu oleh guru
    $kelas = GuruMapel::where('user_id', $userId)
            ->join('kelas', 'guru_mapels.kelas_id', '=', 'kelas.id')
            ->select('kelas.id', 'kelas.nama_kelas')
            ->distinct()
            ->get();

    // Ambil video yang hanya terkait dengan mata pelajaran dan kelas yang diampu
    $videos = Video::with(['mapel', 'kelas']) // Pastikan relasi mapel dan kelas diload
            ->whereHas('mapel', function ($query) use ($mapel) {
                $query->whereIn('id', $mapel->pluck('id')); // Filter berdasarkan mata pelajaran
            })
            ->whereHas('kelas', function ($query) use ($kelas) {
                $query->whereIn('id', $kelas->pluck('id')); // Filter berdasarkan kelas
            })
            ->get();

    return view('guru.manajemen-video.index', compact('videos', 'kelas', 'mapel'));
}


    // Simpan video dari file lokal
    public function storeLocal(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mapel_id' => 'required|string|max:255',
            'kelas_id' => 'required|string|max:255',
            'file' => 'required|file|mimes:mp4,avi,mkv|max:102400', // Maksimal 100MB (102400 KB)
        ]);

        $filePath = $request->file('file')->store('videos', 'public');

        Video::create([
            'judul' => $request->judul,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'file_path' => $filePath,
        ]);

        return redirect()->route('guru.video.index')->with('success', 'Video berhasil diunggah dari lokal!');
    }

    // Simpan video dari YouTube
    public function storeYoutube(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mapel_id' => 'required|string|max:255', // Harus cocok dengan input di form
            'kelas_id' => 'required|string|max:255', // Harus cocok dengan input di form
            'link_youtube' => 'required|url',
        ]);

        // Gunakan mapel_id dan kelas_id sesuai validasi
        Video::create([
            'judul' => $request->judul,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'link_youtube' => $request->link_youtube,
        ]);

        return redirect()->route('guru.video.index')->with('success', 'Video berhasil diunggah dari YouTube!');
    }


    // Hapus video
    public function destroy($id)
    {
        $video = Video::findOrFail($id);

        // Hapus file lokal jika ada
        if ($video->file_path) {
            Storage::disk('public')->delete($video->file_path);
        }

        $video->delete();

        return redirect()->route('guru.video.index')->with('success', 'Video berhasil dihapus!');
    }

    public function play($id)
    {
        $video = Video::findOrFail($id); // Ambil video berdasarkan ID

        return view('guru.video.play', compact('video'));
    }

    public function indexSiswa()
    {
        // Mendapatkan data user yang sedang login
        $user = auth()->user(); // Ambil data user yang login
        $kelasId = $user->kelas_id; // Ambil kelas_id dari user

        // Ambil video berdasarkan kelas siswa atau video umum (null kelas)
        $videos = Video::with(['mapel', 'kelas'])
            ->where('kelas_id', $kelasId) // Filter video berdasarkan kelas siswa
            ->orWhereNull('kelas_id') // Video untuk semua kelas
            ->get();

        return view('siswa.video.index', compact('videos'));
    }


}
