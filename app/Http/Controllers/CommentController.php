<?php

namespace App\Http\Controllers;

use App\Models\Attachment; // 1. Tambahkan model Attachment
use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // 2. Tambahkan DB facade
use Illuminate\Support\Facades\Storage; // 3. Tambahkan Storage facade

class CommentController extends Controller
{
    public function store(Request $request, Thread $thread)
    {
        // 4. Tambahkan validasi untuk file opsional
        $validated = $request->validate([
            'content' => ['required', 'string'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => [
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar',
                'max:5120', // Maksimal 5MB per file
            ],
        ]);

        // 5. Gunakan DB Transaction untuk keamanan data
        try {
            DB::beginTransaction();

            // Buat komentar terlebih dahulu
            $comment = Comment::create([
                'content' => $validated['content'],
                'user_id' => auth()->id(),
                'thread_id' => $thread->id,
            ]);

            // 6. Cek dan simpan lampiran jika ada
            if ($request->hasFile('attachments')) {
                foreach ($validated['attachments'] as $file) {
                    // Simpan file ke storage
                    $path = $file->store('attachments', 'public');

                    // Buat record di tabel attachments, hubungkan ke comment
                    Attachment::create([
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'attachable_id' => $comment->id,
                        'attachable_type' => Comment::class, // Gunakan nama class Comment
                    ]);
                }
            }

            DB::commit(); // Simpan semua perubahan jika berhasil
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua jika ada error
            // Opsional: Log errornya
            // Log::error($e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan komentar.');
        }

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}