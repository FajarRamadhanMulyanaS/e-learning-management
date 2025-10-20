<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany; // 1. Tambahkan use statement ini

class Comment extends Model
{
    use HasFactory; // Standar Laravel, baik untuk ditambahkan

    protected $fillable = ['content', 'user_id', 'thread_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * 2. Tambahkan method ini.
     * Mendefinisikan bahwa satu Comment bisa memiliki banyak lampiran.
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}