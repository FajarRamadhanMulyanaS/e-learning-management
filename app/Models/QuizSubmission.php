<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSubmission extends Model
{
    use HasFactory;
    protected $fillable = ['quiz_id', 'siswa_id', 'file_path', 'nilai'];

    /**
     * Mendefinisikan relasi bahwa submission ini milik satu Quiz.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Mendefinisikan relasi bahwa submission ini milik satu Siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Mendefinisikan relasi bahwa submission ini milik satu User (melalui Siswa).
     */
    public function user()
    {
        return $this->hasOneThrough(User::class, Siswa::class, 'id', 'id', 'siswa_id', 'user_id');
    }
}