<?php

namespace App\Http\Controllers;

use App\Models\GuruMapel;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QuizSubmission;
use Illuminate\Support\Facades\Storage; // <-- TAMBAHKAN INI
use App\Models\User; // <-- TAMBAHKAN INI
use App\Models\Siswa; // <-- TAMBAHKAN INI

class QuizController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen kuis.
     */
    public function index()
    {
        // 1. Ambil semua kuis yang terkait dengan guru yang sedang login
        $quizzes = Quiz::whereHas('guruMapel', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('guruMapel.mapel', 'guruMapel.kelas')->latest()->get();

        // 2. Kirim data quizzes ke view
        return view('Guru.quizz.quizz', compact('quizzes')); // Sesuaikan path view
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
        return view('Guru.quizz.create', [ // Sesuaikan path view
            'guruMapels' => $guruMapels
        ]);
    }

    /**
     * Menyimpan kuis yang baru dibuat ke database.
     */
    public function store(Request $request)
    {
        // Validasi (Sudah benar)
        $request->validate([
            'judul' => 'required|string|max:255',
            'guru_mapel_id' => 'required|exists:guru_mapels,id',
            'description' => 'nullable|string',
            'attachment_file' => 'required_without_all:attachment_link,attachment_image|nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
            'attachment_link' => 'required_without_all:attachment_file,attachment_image|nullable|url',
            'attachment_image' => 'required_without_all:attachment_file,attachment_link|nullable|image|max:2048',
        ], [
            'attachment_file.required_without_all' => 'Anda harus melampirkan setidaknya satu file, link, atau gambar.',
            'attachment_link.required_without_all' => 'Anda harus melampirkan setidaknya satu file, link, atau gambar.',
            'attachment_image.required_without_all' => 'Anda harus melampirkan setidaknya satu file, link, atau gambar.',
        ]);

        $filePath = null;
        $imagePath = null;

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
        // Otorisasi (Sudah benar)
        if ($quiz->guruMapel->user_id != Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $guruMapels = GuruMapel::where('user_id', Auth::id())->with(['mapel', 'kelas'])->get();
        return view('Guru.quizz.edit', compact('quiz', 'guruMapels')); // Sesuaikan path view
    }

    /**
     * Memperbarui data kuis di database.
     */
    public function update(Request $request, Quiz $quiz)
    {
        // Otorisasi (Sudah benar)
        if ($quiz->guruMapel->user_id != Auth::id()) {
            abort(403);
        }

        // Validasi data (Sudah benar)
        $request->validate([
            'judul' => 'required|string|max:255',
            'guru_mapel_id' => 'required|exists:guru_mapels,id',
            'description' => 'nullable|string',
            'attachment_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
            'attachment_link' => 'nullable|url',
            'attachment_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['judul', 'guru_mapel_id', 'description', 'attachment_link']);

        // Proses update file (Sudah benar)
        if ($request->hasFile('attachment_file')) {
            if ($quiz->attachment_file) {
                Storage::disk('public')->delete($quiz->attachment_file);
            }
            $data['attachment_file'] = $request->file('attachment_file')->store('quiz_attachments/files', 'public');
        }

        // Proses update gambar (Sudah benar)
        if ($request->hasFile('attachment_image')) {
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
        // Otorisasi (Sudah benar)
        if ($quiz->guruMapel->user_id != Auth::id()) {
            abort(403);
        }

        // Hapus file dan gambar (Sudah benar)
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

    /**
     * Menampilkan detail kuis beserta daftar siswa di kelas target
     * dan status pengumpulan mereka.
     *
     * !! METHOD INI YANG DIPERBAIKI !!
     */
    public function show(Quiz $quiz)
    {
        // Otorisasi (Sudah benar)
        if ($quiz->guruMapel->user_id != Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // 1. Eager load relasi yang dibutuhkan oleh Quiz
        $quiz->load('guruMapel.mapel', 'guruMapel.kelas'); // Tidak perlu ->users di sini

        // 2. Ambil ID kelas dari relasi quiz
        $kelasId = $quiz->guruMapel->kelas_id;

        // 3. Ambil daftar siswa (User) di kelas tersebut
        // !! INI QUERY PERBAIKANNYA !!
        $siswaDiKelas = User::where('role', 'siswa')
            ->whereHas('siswa', function ($query) use ($kelasId) {
                // Filter berdasarkan siswa.kelas_id
                $query->where('kelas_id', $kelasId);
            })
            // Eager load data siswa & status pengumpulan quiz INI
            ->with([
                'siswa', // Ambil data NISN dll
                // !! PERBAIKAN: Load quizSubmissions dari relasi Siswa !!
                'siswa.quizSubmissions' => function ($query) use ($quiz) {
                    $query->where('quiz_id', $quiz->id); // Hanya load submission untuk quiz ini
                }
            ])
            ->get();

        // 4. (Opsional) Ambil semua submission untuk kuis ini jika diperlukan terpisah
        //    (Sebenarnya sudah ada di $siswaDiKelas->siswa->quizSubmissions)
        // $submissions = QuizSubmission::where('quiz_id', $quiz->id)
        //                     ->get()
        //                     ->keyBy('siswa_id'); // Key berdasarkan siswa_id sekarang

        // 5. Kirim data ke view detail quiz
        //    Ganti 'students' menjadi 'siswaDiKelas', hapus 'submissions' jika tidak perlu
        return view('Guru.quizz.show', compact('quiz', 'siswaDiKelas')); // Sesuaikan path view Anda
    }


    public function grade(QuizSubmission $submission)
    {
        // Otorisasi (Sudah benar)
        if ($submission->quiz->guruMapel->user_id != Auth::id()) {
            abort(403);
        }

        // Ambil data dengan relasi yang benar
        $submission->load('quiz', 'siswa.user'); // Load siswa dan user-nya

        return view('Guru.quizz.grade', compact('submission')); // Sesuaikan path view
    }

    public function storeGrade(Request $request, QuizSubmission $submission)
    {
        // Otorisasi (Sudah benar)
        if ($submission->quiz->guruMapel->user_id != Auth::id()) {
            abort(403);
        }

        // Validasi (Sudah benar)
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        // Simpan nilai (Sudah benar)
        $submission->update([
            'nilai' => $request->nilai,
        ]);

        // Ambil nama siswa dari relasi yang benar dengan null check
        $namaSiswa = $submission->siswa && $submission->siswa->user 
            ? $submission->siswa->user->username 
            : 'Siswa'; // Akses username via siswa->user dengan null check

        // Redirect (Sudah benar)
        return redirect()->route('guru.quiz.show', $submission->quiz_id)->with('success', 'Nilai untuk ' . $namaSiswa . ' berhasil disimpan.');
    }
}
