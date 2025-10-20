<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Semester;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    // Menampilkan daftar mapel
    public function index(Request $request)
    {
        $query = Mapel::with('semester');
        
        // Filter berdasarkan semester jika dipilih
        if ($request->has('semester_id') && $request->semester_id) {
            $query->where('semester_id', $request->semester_id);
        }
        
        $mapels = $query->orderBy('nama_mapel')->get();
        $semesters = Semester::orderBy('tahun_ajaran', 'desc')
                           ->orderBy('nama_semester', 'asc')
                           ->get();
        $selectedSemester = $request->semester_id;
        
        return view('admin.mapel.index', compact('mapels', 'semesters', 'selectedSemester'));
    }

    // Menampilkan form untuk menambahkan mapel baru
    public function create()
    {
        $semesters = Semester::orderBy('tahun_ajaran', 'desc')
                           ->orderBy('nama_semester', 'asc')
                           ->get();
        return view('admin.mapel.create', compact('semesters'));
    }

    // Menyimpan mapel baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mapels',
            'nama_mapel' => 'required',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        Mapel::create($request->all());
        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    // Menampilkan form edit untuk mapel
    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);
        $semesters = Semester::orderBy('tahun_ajaran', 'desc')
                           ->orderBy('nama_semester', 'asc')
                           ->get();
        return view('admin.mapel.edit', compact('mapel', 'semesters'));
    }

    // Memperbarui data mapel di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mapels,kode_mapel,' . $id,
            'nama_mapel' => 'required',
            'semester_id' => 'required|exists:semesters,id',
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
