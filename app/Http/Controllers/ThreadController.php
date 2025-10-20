<?php

namespace App\Http\Controllers;

use App\Models\Attachment; // 1. Tambahkan model Attachment
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // 2. Tambahkan DB facade untuk transaction
use Illuminate\Support\Facades\Storage; // 3. Tambahkan Storage facade untuk file

class ThreadController extends Controller
{
    public function index()
    {
        // Eager load attachments untuk efisiensi query
        $threads = Thread::with(['user', 'attachments'])->latest()->paginate(10);
        return view('siswa.diskusi.index', compact('threads'));
    }

    public function create()
    {
        return view('siswa.diskusi.create');
    }

    public function store(Request $request)
    {
        // 4. Tambahkan validasi untuk file opsional
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => [
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar',
                'max:5120', // Maksimal 5MB per file
            ],
        ]);

        // 5. Gunakan DB Transaction untuk memastikan data konsisten
        try {
            DB::beginTransaction();

            // Buat thread terlebih dahulu untuk mendapatkan ID-nya
            $thread = Thread::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'user_id' => auth()->id(),
            ]);

            // 6. Cek apakah ada file yang di-upload
            if ($request->hasFile('attachments')) {
                foreach ($validated['attachments'] as $file) {
                    // Simpan file ke storage dan dapatkan path-nya
                    $path = $file->store('attachments', 'public');

                    // Buat record di tabel attachments
                    Attachment::create([
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'attachable_id' => $thread->id,
                        'attachable_type' => Thread::class, // Gunakan nama class Thread
                    ]);
                }
            }

            DB::commit(); // Jika semua berhasil, simpan perubahan ke database
        } catch (\Exception $e) {
            DB::rollBack(); // Jika ada error, batalkan semua query
            // Opsional: catat error atau tampilkan pesan error
            return back()->withInput()->with('error', 'Terjadi kesalahan saat membuat thread.');
        }

        return redirect()->route('threads.index')->with('success', 'Thread berhasil dibuat.');
    }

    public function show(Thread $thread)
    {
        // Eager load comments dan attachments untuk performa
        $thread->load(['comments.user', 'comments.attachments', 'user', 'attachments']);
        return view('siswa.diskusi.show', compact('thread'));
    }
}