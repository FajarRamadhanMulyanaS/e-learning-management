<?php

namespace App\Http\Controllers;

use App\Models\GuruMapel;
use App\Models\Quiz; // 1. Pastikan Anda meng-import model Quiz
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QuizSubmission;

class QuizController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen kuis.
     */
public function index()
    {
        // 1. Ambil semua kuis yang terkait dengan guru yang sedang login
        // Diurutkan dari yang paling baru
        $quizzes = Quiz::whereHas('guruMapel', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('guruMapel.mapel', 'guruMapel.kelas')->latest()->get();

        // 2. Kirim data quizzes ke view
        return view('Guru.quizz.quizz', compact('quizzes'));
    }
    /**
     * Menampilkan form untuk membuat kuis baru.
     */
    public function create()
    {
        $guruId = Auth::id();
        $guruMapels = GuruMapel::where('user_id', $guruId)
                                ->with(['mapel', 'kelas'])
                                ->get();
        return view('Guru.quizz.create', [
            'guruMapels' => $guruMapels
        ]);
    }

    /**
     * Menyimpan kuis yang baru dibuat ke database.
     */
public function store(Request $request)
{
    // Modifikasi bagian validasi di sini
    $request->validate([
        'judul' => 'required|string|max:255',
        'guru_mapel_id' => 'required|exists:guru_mapels,id',
        'description' => 'nullable|string',
        
        // Tambahkan 'required_without_all' pada setiap field lampiran
        'attachment_file' => 'required_without_all:attachment_link,attachment_image|nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
        'attachment_link' => 'required_without_all:attachment_file,attachment_image|nullable|url',
        'attachment_image' => 'required_without_all:attachment_file,attachment_link|nullable|image|max:2048',
    ], [
        // Tambahkan pesan custom agar lebih jelas bagi pengguna
        'attachment_file.required_without_all' => 'Anda harus melampirkan setidaknya satu file, link, atau gambar.',
        'attachment_link.required_without_all' => 'Anda harus melampirkan setidaknya satu file, link, atau gambar.',
        'attachment_image.required_without_all' => 'Anda harus melampirkan setidaknya satu file, link, atau gambar.',
    ]);

    $filePath = null;
    $imagePath = null;

    // ... (sisa dari method store Anda tetap sama)
    
    if ($request->hasFile('attachment_file')) {
        $filePath = $request->file('attachment_file')->store('quiz_attachments/files', 'public');
    }
    
    if ($request->hasFile('attachment_image')) {
        $imagePath = $request->file('attachment_image')->store('quiz_attachments/images', 'public');
    }
    
    Quiz::create([
        'judul' => $request->judul,
        'guru_mapel_id' => $request->guru_mapel_id,
        'description' => $request->description,
        'attachment_link' => $request->attachment_link,
        'attachment_file' => $filePath,
        'attachment_image' => $imagePath,
    ]);

    return redirect()->route('guru.quiz.index')->with('success', 'Kuis berhasil dibuat!');
}
    public function edit(Quiz $quiz)
    {
        // Otorisasi: pastikan guru hanya bisa mengedit kuis miliknya
        if ($quiz->guruMapel->user_id != Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $guruMapels = GuruMapel::where('user_id', Auth::id())->with(['mapel', 'kelas'])->get();
        return view('Guru.quizz.edit', compact('quiz', 'guruMapels'));
    }

    /**
     * Memperbarui data kuis di database.
     */
    public function update(Request $request, Quiz $quiz)
    {
        // Otorisasi
        if ($quiz->guruMapel->user_id != Auth::id()) {
            abort(403);
        }

        // Validasi data (sama seperti store, tapi aturan required_without_all tidak seketat create)
        $request->validate([
            'judul' => 'required|string|max:255',
            'guru_mapel_id' => 'required|exists:guru_mapels,id',
            'description' => 'nullable|string',
            'attachment_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
            'attachment_link' => 'nullable|url',
            'attachment_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['judul', 'guru_mapel_id', 'description', 'attachment_link']);

        // Proses update file jika ada file baru yang diupload
        if ($request->hasFile('attachment_file')) {
            // Hapus file lama jika ada
            if ($quiz->attachment_file) {
                Storage::disk('public')->delete($quiz->attachment_file);
            }
            $data['attachment_file'] = $request->file('attachment_file')->store('quiz_attachments/files', 'public');
        }

        // Proses update gambar jika ada gambar baru yang diupload
        if ($request->hasFile('attachment_image')) {
            // Hapus gambar lama jika ada
            if ($quiz->attachment_image) {
                Storage::disk('public')->delete($quiz->attachment_image);
            }
            $data['attachment_image'] = $request->file('attachment_image')->store('quiz_attachments/images', 'public');
        }

        $quiz->update($data);

        return redirect()->route('guru.quiz.index')->with('success', 'Kuis berhasil diperbarui!');
    }

    public function destroy(Quiz $quiz)
    {
        // Otorisasi
        if ($quiz->guruMapel->user_id != Auth::id()) {
            abort(403);
        }

        // Hapus file dan gambar dari storage jika ada
        if ($quiz->attachment_file) {
            Storage::disk('public')->delete($quiz->attachment_file);
        }
        if ($quiz->attachment_image) {
            Storage::disk('public')->delete($quiz->attachment_image);
        }

        // Hapus data dari database
        $quiz->delete();

        return redirect()->route('guru.quiz.index')->with('success', 'Kuis berhasil dihapus!');
    }

    public function show(Quiz $quiz)
    {
        // Otorisasi
        if ($quiz->guruMapel->user_id != Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // Ambil semua data yang dibutuhkan
        // PERBAIKAN DI SINI: ganti ->user menjadi ->users
        $quiz->load('guruMapel.mapel', 'guruMapel.kelas.users');

        // Ambil semua siswa dari kelas yang ditugaskan untuk kuis ini
        // PERBAIKAN DI SINI: ganti ->user menjadi ->users
        $students = $quiz->guruMapel->kelas->users;

        // Ambil semua submission untuk kuis ini, di-indeks berdasarkan user_id agar mudah diakses
        $submissions = \App\Models\QuizSubmission::where('quiz_id', $quiz->id)
                                                ->get()
                                                ->keyBy('user_id');

        return view('Guru.quizz.show', compact('quiz', 'students', 'submissions'));
    }

    public function grade(QuizSubmission $submission)
    {
        // Otorisasi: Pastikan guru adalah pemilik kuis dari jawaban ini
        if ($submission->quiz->guruMapel->user_id != Auth::id()) {
            abort(403);
        }

        // Ambil semua data yang dibutuhkan (submission, quiz, student)
        $submission->load('quiz', 'user');

        return view('Guru.quizz.grade', compact('submission'));
    }

    public function storeGrade(Request $request, QuizSubmission $submission)
    {
        // Otorisasi
        if ($submission->quiz->guruMapel->user_id != Auth::id()) {
            abort(403);
        }

        // Validasi: Pastikan nilai adalah angka antara 0 - 100
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        // Simpan nilai ke database
        $submission->update([
            'nilai' => $request->nilai,
        ]);

        // Redirect kembali ke halaman detail kuis dengan pesan sukses
        return redirect()->route('guru.quiz.show', $submission->quiz_id)->with('success', 'Nilai untuk siswa ' . $submission->user->username . ' berhasil disimpan.');
    }
}