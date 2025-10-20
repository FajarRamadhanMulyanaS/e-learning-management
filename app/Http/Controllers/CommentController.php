<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Thread;
class CommentController extends Controller
{
    public function store(Request $request, Thread $thread)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'thread_id' => $thread->id,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
