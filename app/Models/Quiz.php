<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // 1. Tambahkan use statement ini

class Quiz extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'guru_mapel_id',
        'description',
        'attachment_file',
        'attachment_link',
        'attachment_image',
    ];

    /**
     * Mendefinisikan relasi bahwa setiap Kuis "milik" satu GuruMapel.
     */
    public function guruMapel()
    {
        return $this->belongsTo(GuruMapel::class);
    }

    /**
     * 2. TAMBAHKAN METHOD RELASI INI
     * Relasi ke tabel quiz_submissions, HANYA untuk siswa yang sedang login.
     */
    public function mySubmission()
    {
        // hasOne karena satu siswa hanya bisa punya satu submission per kuis
        return $this->hasOne(QuizSubmission::class)->where('user_id', Auth::id());
    }

    /**
     * Relasi ke semua quiz submissions
     */
    public function submissions()
    {
        return $this->hasMany(QuizSubmission::class, 'quiz_id');
    }
}