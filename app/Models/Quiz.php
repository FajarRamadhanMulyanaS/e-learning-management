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
     * Relasi ke semua submission quiz ini
     */
    public function submissions()
    {
        return $this->hasMany(QuizSubmission::class, 'quiz_id', 'id');
    }

    /**
     * Relasi ke submission quiz untuk siswa tertentu
     */
    public function submissionForSiswa($siswaId)
    {
        return $this->hasOne(QuizSubmission::class, 'quiz_id', 'id')->where('siswa_id', $siswaId);
    }
}