<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
class ThreadController extends Controller
{
    //
    public function index()
    {
        $threads = Thread::with('user')->latest()->paginate(10);
        return view('siswa.diskusi.index', compact('threads'));
    }

    public function create()
    {
        return view('siswa.diskusi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Thread::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('threads.index')->with('success', 'Thread berhasil dibuat.');
    }

    public function show(Thread $thread)
    {
        return view('siswa.diskusi.show', compact('thread'));
    }
}
