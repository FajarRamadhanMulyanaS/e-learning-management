<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Menampilkan daftar mata pelajaran
    public function index()
    {
        $courses = Course::with('guru')->get(); // Mengambil semua mata pelajaran dengan relasi guru
        return view('admin.courses.index', compact('courses'));
    }

    // Menampilkan form untuk menambahkan mata pelajaran baru
    public function create()
    {
        $guru = User::where('role', 'guru')->get(); // Mengambil data guru
        return view('admin.courses.create', compact('guru'));
    }

    // Menyimpan mata pelajaran baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'users_id' => 'required|exists:users,id',
        ]);

        Course::create($request->all()); // Menyimpan data baru

        return redirect()->route('admin.courses.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit mata pelajaran
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $guru = User::where('role', 'guru')->get();
        return view('admin.courses.edit', compact('course', 'guru'));
    }

    // Mengupdate data mata pelajaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'users_id' => 'required|exists:users,id',
        ]);

        $course = Course::findOrFail($id);
        $course->update($request->all());

        return redirect()->route('admin.courses.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    // Menghapus mata pelajaran
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
