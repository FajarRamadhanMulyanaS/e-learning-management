<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\GuruMapel;
use App\Models\BalasanPesan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    // Menampilkan halaman kotak pesan
    public function index()
    {
        $user = Auth::user();

        // Ambil pesan masuk untuk siswa yang sedang login
        $pesanMasuk = Pesan::where('penerima_id', $user->id)
            ->with('pengirim') // Relasi ke pengirim
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa.pesan.index', compact('pesanMasuk'));
    }

    public function showSiswa($id)
    {
        $pesan = Pesan::with(['pengirim', 'balasan.pengirim'])->findOrFail($id);

        // Tandai pesan sebagai telah dibaca
        $pesan->is_read = 1;
        $pesan->save();
        return view('siswa.pesan.show', compact('pesan'));
    }

    public function showSiswa2($id)
    {
        $pesan = Pesan::with(['pengirim', 'balasan.pengirim'])->findOrFail($id);

        // Tandai pesan sebagai telah dibaca
        $pesan->is_read = 1;
        $pesan->save();
        return view('siswa.pesan.balas_pesansendiri', compact('pesan'));
    }


    public function pesan()
    {
        $user = Auth::user();
        $guru = User::where('role', 'Guru')->get();
        // Pesan masuk
        $pesanMasuk = Pesan::where('penerima_id', $user->id)->get();
        // Pesan terkirim
        $pesanTerkirim = Pesan::where('pengirim_id', $user->id)->get();

        return view('siswa.pesan.kirim_pesan', compact('pesanMasuk','guru', 'pesanTerkirim'));
    }

    // Menampilkan form kirim pesan
    public function create()
    {
        // Ambil data penerima hanya yang memiliki role 'Guru'
        $guru = User::where('role', 'Guru')->get();

        return view('siswa.pesan.create', compact('guru'));
    }

    // Mengirim pesan
    public function store(Request $request)
    {
        $request->validate([
            'penerima_id' => 'required|exists:users,id',
            'judul' => 'required|string',
            'isi_pesan' => 'required|string',
        ]);

        Pesan::create([
            'pengirim_id' => Auth::id(),
            'penerima_id' => $request->penerima_id,
            'judul' => $request->judul,
            'isi_pesan' => $request->isi_pesan,
        ]);

        return redirect()->route('pesan.pengirim')->with('success', 'Pesan berhasil dikirim.');
    }

    // Memperbarui pesan
    public function update(Request $request, $id)
    {
        $pesan = Pesan::where('pengirim_id', auth()->id())->findOrFail($id);

        $request->validate([
            'judul' => 'required|string',
            'isi_pesan' => 'required|string|max:1000',
        ]);

        $pesan->update([
            'judul' => $request->judul,
            'isi_pesan' => $request->isi_pesan,
        ]);

        return redirect()->route('pesan.index')->with('success', 'Pesan berhasil diperbarui.');
    }


    public function destroy($id)
    {
        // Hapus pesan
        $pesan = Pesan::where('pengirim_id', auth()->id())->findOrFail($id);
        $pesan->delete();
        return redirect()->route('pesan.pengirim')->with('success', 'Pesan berhasil di hapus.');
    }

    // ============================================================================================================
    // ============================================================================================================
    // ============================================================================================================
    public function indexGuru()
    {
        $pesanMasuk = Pesan::where('penerima_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('guru.pesan.index', compact('pesanMasuk'));
    }

    // Menampilkan form kirim pesan
    public function createGuru()
    {
        // Ambil data guru yang sedang login
        $guru = auth()->user(); // Pastikan user yang login adalah guru

        // Ambil kelas yang diajar oleh guru tersebut dari `guru_mapels`
        $kelasIds = GuruMapel::where('user_id', $guru->id)->pluck('kelas_id');

        // Ambil siswa berdasarkan kelas yang diampu guru
        $siswa = User::where('role', 'siswa')
            ->whereHas('siswa', function ($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })
            ->get();

        return view('guru.pesan.create', compact('siswa'));
    }

    public function pesanGuru()
    {
        $user = Auth::user();
        // Ambil kelas yang diajar oleh guru tersebut dari `guru_mapels`
        $kelasIds = GuruMapel::where('user_id', $user->id)->pluck('kelas_id');

        // Ambil siswa berdasarkan kelas yang diampu guru
        $siswa = User::where('role', 'siswa')
            ->whereHas('siswa', function ($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })
            ->get();
        // Pesan masuk
        $pesanMasuk = Pesan::where('penerima_id', $user->id)->get();
        // Pesan terkirim
        $pesanTerkirim = Pesan::where('pengirim_id', $user->id)->get();

        return view('guru.pesan.kirim_pesan', compact('pesanMasuk','siswa', 'pesanTerkirim'));
    }

    // Mengirim pesan
    public function storeGuru(Request $request)
    {
        $request->validate([
            'penerima_id' => 'required|exists:users,id',
            'judul' => 'required|string',
            'isi_pesan' => 'required|string',
        ]);

        Pesan::create([
            'pengirim_id' => Auth::id(),
            'penerima_id' => $request->penerima_id,
            'judul' => $request->judul,
            'isi_pesan' => $request->isi_pesan,
        ]);

        return redirect()->route('pesan.pengirim')->with('success', 'Pesan berhasil dikirim.');
    }

    // Memperbarui pesan
    public function updateGuru(Request $request, $id)
    {
        $pesan = Pesan::where('pengirim_id', auth()->id())->findOrFail($id);

        $request->validate([
            'judul' => 'required|string',
            'isi_pesan' => 'required|string|max:1000',
        ]);

        $pesan->update([
            'judul' => $request->judul,
            'isi_pesan' => $request->isi_pesan,
        ]);

        return redirect()->route('pesan.index')->with('success', 'Pesan berhasil diperbarui.');
    }


    public function destroyGuru($id)
    {
        // Hapus pesan
        $pesan = Pesan::where('pengirim_id', auth()->id())->findOrFail($id);
        $pesan->delete();
        return redirect()->route('pesan.pengirim')->with('success', 'Pesan berhasil di
        hapus.');
    }


    public function showGuru($id)
    {
        $pesan = Pesan::with(['pengirim', 'balasan.pengirim'])->findOrFail($id);

        // Tandai pesan sebagai telah dibaca
        $pesan->is_read = 1;
        $pesan->save();

        return view('guru.pesan.balas_pesan', compact('pesan'));
    }
    public function showGuru2($id)
    {
        $pesan = Pesan::with(['pengirim', 'balasan.pengirim'])->findOrFail($id);

        // Tandai pesan sebagai telah dibaca
        $pesan->is_read = 1;
        $pesan->save();

        return view('guru.pesan.balas_pesansendiri', compact('pesan'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'isi' => 'required|string|max:500',
        ]);

        $pesan = Pesan::findOrFail($id);

        // Simpan balasan ke tabel `balasan_pesan`
        BalasanPesan::create([
            'pesan_id' => $pesan->id,
            'pengirim_id' => auth()->user()->id, // ID guru yang sedang login
            'isi' => $request->isi,
        ]);

        return redirect()->back()->with('success', 'Balasan berhasil dikirim.');
    }
}
