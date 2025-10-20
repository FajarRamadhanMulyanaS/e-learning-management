<?php

namespace App\Http\Controllers;

use App\Models\Essay;
use Illuminate\Http\Request;

class EssayController extends Controller
{
    public function index($ujian_id)
    {
        $soalEssay = Essay::where('ujian_id', $ujian_id)->paginate(10);
        return view('guru.manajemen-ujian.essay', compact('soalEssay', 'ujian_id'));
    }

    public function store(Request $request, $ujian_id)
    {
        $request->validate([
            'soal' => 'required',
        ]);

        Essay::create([
            'ujian_id' => $ujian_id,
            'soal' => $request->soal,
        ]);

        return redirect()->route('guru.manajemen-ujian.essay', $ujian_id)->with('success', 'Soal Essay berhasil ditambahkan.');
    }

    public function update(Request $request, $ujian_id, $id)
    {
        $request->validate([
            'soal' => 'required',
        ]);

        $Essay = Essay::findOrFail($id);
        $Essay->update([
            'soal' => $request->soal,
        ]);

        return redirect()->route('guru.manajemen-ujian.essay', $ujian_id)->with('success', 'Soal Essay berhasil diperbarui.');
    }

    public function destroy($ujian_id, $id)
    {
        Essay::destroy($id);
        return redirect()->route('guru.manajemen-ujian.essay', $ujian_id)->with('success', 'Soal Esai berhasil dihapus.');
    }
}
