<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany; // 1. Tambahkan use statement ini

class Thread extends Model
{
    use HasFactory; // Tambahkan ini jika belum ada

    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 2. Tambahkan method ini untuk relasi ke lampiran.
     * Mendefinisikan bahwa satu Thread bisa memiliki banyak lampiran.
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}