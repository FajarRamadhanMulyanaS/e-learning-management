<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    // Menampilkan daftar mapel
    public function index()
    {
        $mapels = Mapel::all();
        return view('admin.mapel.index', compact('mapels'));
    }

    // Menampilkan form untuk menambahkan mapel baru
    public function create()
    {
        return view('admin.mapel.create');
    }

    // Menyimpan mapel baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mapels',
            'nama_mapel' => 'required',
        ]);

        Mapel::create($request->all());
        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    // Menampilkan form edit untuk mapel
    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);
        return view('admin.mapel.edit', compact('mapel'));
    }

    // Memperbarui data mapel di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mapels,kode_mapel,' . $id,
            'nama_mapel' => 'required',
        ]);

        $mapel = Mapel::findOrFail($id);
        $mapel->update($request->all());

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    // Menghapus mapel dari database
    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
