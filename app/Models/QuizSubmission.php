<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSubmission extends Model
{
    use HasFactory;

    protected $table = 'quiz_submissions';

    protected $fillable = [
        'quiz_id',
        'user_id',
        'file_path',
        'nilai',
    ];

    /**
     * Relasi ke tabel Quiz
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    /**
     * Relasi ke tabel User
     * Karena di tabel ini foreign key-nya user_id, bukan siswa_id
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi tidak langsung ke Siswa
     * Agar bisa diakses dari Siswa::with('quizSubmissions')
     */
    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id', 'user_id');
    }
}
