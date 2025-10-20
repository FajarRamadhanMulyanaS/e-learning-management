<?php

namespace App\Http\Controllers;

use App\Models\GuruMapel;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;

class GuruMapelController extends Controller
{
    // Menampilkan daftar guru mapel
    public function index()
    {
        $guruMapels = GuruMapel::with(['user', 'mapel', 'kelas'])->get(); // Mengambil data relasi
        $guru = User::where('role', 'guru')->get(); // Mengambil data guru dari tabel user
        $mapels = Mapel::all(); // Mengambil semua mapel
        $kelas = Kelas::all(); // Mengambil semua kelas

        return view('admin.guru-mapel.index', compact('guruMapels', 'guru', 'mapels', 'kelas'));
    }



    // Menampilkan form untuk menambah guru mapel baru
    public function create()
    {
        $guru = User::where('role', 'guru')->get();
        $mapels = Mapel::all();
        $kelas = Kelas::all();
        return view('admin.guru-mapel.create', compact('guru', 'mapels', 'kelas'));
    }

    // Menyimpan guru mapel baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        GuruMapel::create([
            'user_id' => $request->user_id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('admin.guru-mapel.index')->with('success', 'Guru Mapel berhasil ditambahkan');
    }

    // Menampilkan form edit guru mapel
    public function edit($id)
    {
        $guruMapel = GuruMapel::findOrFail($id);
        $guru = User::where('role', 'guru')->get();
        $mapels = Mapel::all();
        $kelas = Kelas::all();
        return view('admin.guru-mapel.edit', compact('guruMapel', 'guru', 'mapels', 'kelas'));
    }

    // Memperbarui data guru mapel
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $guruMapel = GuruMapel::findOrFail($id);
        $guruMapel->update([
            'user_id' => $request->user_id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('admin.guru-mapel.index')->with('success', 'Data Guru Mapel berhasil diperbarui');
    }

    // Menghapus guru mapel
    public function destroy($id)
    {
        $guruMapel = GuruMapel::findOrFail($id);
        $guruMapel->delete();

        return redirect()->route('admin.guru-mapel.index')->with('success', 'Guru Mapel berhasil dihapus');
    }
}
