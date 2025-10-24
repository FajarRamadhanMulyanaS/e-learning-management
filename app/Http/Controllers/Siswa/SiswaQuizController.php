<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaQuizController extends Controller
{
    public function index()
    {
        $kelasId = Auth::user()->siswa->kelas_id;

        if (!$kelasId) {
            return view('Siswa.quiz.index', ['quizzes' => collect()]);
        }

        $quizzes = Quiz::whereHas('guruMapel', function ($query) use ($kelasId) {
            $query->where('kelas_id', $kelasId);
        })
        ->with(['guruMapel.mapel', 'guruMapel.user'])
        ->latest()
        ->get();

        // Load submissions untuk setiap quiz secara terpisah
        foreach ($quizzes as $quiz) {
            $quiz->mySubmission = $quiz->submissions()->where('siswa_id', Auth::user()->siswa->id)->first();
        }

        return view('Siswa.quiz.index', compact('quizzes'));
    }
    public function show(Quiz $quiz)
    {
        // Otorisasi
        if ($quiz->guruMapel->kelas_id != Auth::user()->siswa->kelas_id) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini.');
        }

        // Load relasi yang diperlukan
        $quiz->load('guruMapel.mapel', 'guruMapel.user');
        
        // Load submission untuk user yang sedang login
        $quiz->mySubmission = $quiz->submissions()->where('siswa_id', Auth::user()->siswa->id)->first();

        return view('Siswa.quiz.show', compact('quiz'));
    }
    public function submit(Request $request, Quiz $quiz)
    {
        // 1. Validasi input: pastikan ada file yang diupload dan sesuai format
        $request->validate([
            'submission_file' => 'required|file|mimes:pdf,doc,docx,jpg,png,zip|max:10240', // Max 10MB
        ]);

        // 2. Otorisasi: pastikan siswa hanya bisa submit ke kuis untuk kelasnya
        if ($quiz->guruMapel->kelas_id != Auth::user()->siswa->kelas_id) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini.');
        }

        // 3. Simpan file yang di-upload ke storage
        $filePath = $request->file('submission_file')->store('quiz_submissions', 'public');

        // 4. Simpan catatan pengumpulan ke database
        // updateOrCreate digunakan agar jika siswa submit lagi, data lama akan diperbarui, bukan membuat data baru
        QuizSubmission::updateOrCreate(
            [
                'quiz_id' => $quiz->id,
                'siswa_id' => Auth::user()->siswa->id,
            ],
            [
                'file_path' => $filePath,
            ]
        );

        // 5. Redirect kembali ke halaman daftar kuis dengan pesan sukses
        return redirect()->route('siswa.quiz.index')->with('success', 'Jawaban Anda untuk kuis "'.$quiz->judul.'" telah berhasil dikumpulkan!');
    }
}