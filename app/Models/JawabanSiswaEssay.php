<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSiswaEssay extends Model
{
    use HasFactory;

    protected $table = 'jawaban_siswa_essay';

    // Fields yang bisa diisi (mass-assignable)
    protected $fillable = [
        'siswa_id',
        'ujian_id',
        'essay_id',
        'jawaban_siswa',
        'nilai_essay'
    ];

    // Relasi ke hasil ujian
    public function hasilUjian()
    {
        return $this->belongsTo(HasilUjian::class, 'hasil_ujian_id');
    }

    // Relasi ke soal essay
    public function soal()
    {
        return $this->belongsTo(Essay::class, 'soal_id');
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }
}
