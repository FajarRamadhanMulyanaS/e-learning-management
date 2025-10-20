<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    // Menampilkan daftar semester
    public function index()
    {
        $semesters = Semester::orderBy('tahun_ajaran', 'desc')
                           ->orderBy('nama_semester', 'asc')
                           ->get();
        return view('admin.semester.index', compact('semesters'));
    }

    // Menampilkan form tambah semester
    public function create()
    {
        return view('admin.semester.create');
    }

    // Menyimpan semester baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_semester' => 'required|string|max:255',
            'tahun_ajaran' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        // Jika semester ini diaktifkan, nonaktifkan yang lain
        if ($request->has('is_active') && $request->is_active) {
            Semester::query()->update(['is_active' => false]);
        }

        Semester::create($data);
        return redirect()->route('admin.semester.index')->with('success', 'Semester berhasil ditambahkan.');
    }

    // Menampilkan form edit semester
    public function edit($id)
    {
        $semester = Semester::findOrFail($id);
        return view('admin.semester.edit', compact('semester'));
    }

    // Memperbarui semester
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_semester' => 'required|string|max:255',
            'tahun_ajaran' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $semester = Semester::findOrFail($id);
        $data = $request->all();

        // Jika semester ini diaktifkan, nonaktifkan yang lain
        if ($request->has('is_active') && $request->is_active) {
            Semester::where('id', '!=', $id)->update(['is_active' => false]);
        }

        $semester->update($data);
        return redirect()->route('admin.semester.index')->with('success', 'Semester berhasil diperbarui.');
    }

    // Menghapus semester
    public function destroy($id)
    {
        $semester = Semester::findOrFail($id);
        
        // Cek apakah ada mapel yang menggunakan semester ini
        if ($semester->mapels()->count() > 0) {
            return redirect()->route('admin.semester.index')
                           ->with('error', 'Tidak dapat menghapus semester karena masih ada mata pelajaran yang menggunakan semester ini.');
        }

        $semester->delete();
        return redirect()->route('admin.semester.index')->with('success', 'Semester berhasil dihapus.');
    }

    // Mengaktifkan semester
    public function activate($id)
    {
        $semester = Semester::findOrFail($id);
        $semester->activate();
        
        return redirect()->route('admin.semester.index')->with('success', 'Semester berhasil diaktifkan.');
    }
}
