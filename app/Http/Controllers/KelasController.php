<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    // Menampilkan daftar kelas
    public function index()
    {
        $kelas = Kelas::all();
        return view('admin.kelas.index', compact('kelas'));
    }

    // Menampilkan form tambah kelas
    public function create()
    {
        return view('admin.kelas.create');
    }

    // Menyimpan kelas baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'required|unique:kelas',
            'nama_kelas' => 'required',
        ]);

        Kelas::create($request->all());
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    // Menampilkan form edit kelas
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.edit', compact('kelas'));
    }

    // Memperbarui kelas
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_kelas' => 'required|unique:kelas,kode_kelas,' . $id,
            'nama_kelas' => 'required',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    // Menghapus kelas
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
