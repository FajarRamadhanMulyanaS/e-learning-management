<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSubmission extends Model
{
    use HasFactory;
    protected $fillable = ['quiz_id', 'user_id', 'file_path', 'nilai'];

    /**
     * Mendefinisikan relasi bahwa submission ini milik satu Quiz.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Mendefinisikan relasi bahwa submission ini milik satu User (Siswa).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}