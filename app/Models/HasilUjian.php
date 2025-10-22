<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    use HasFactory;

    protected $table = 'hasil_ujian';

    // Fields yang bisa diisi (mass-assignable)
    protected $fillable = [
        'ujian_id',
        'siswa_id',
        'nilai_pilgan',
        'total_nilai_essay',

    ];

    // Relasi ke model Ujian
    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }

    // Relasi ke model User (siswa)
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    // Relasi ke jawaban pilihan ganda
    public function jawabanPilgan()
    {
        return $this->hasMany(JawabanSiswaPilgan::class, 'hasil_ujian_id');
    }

    // Relasi ke jawaban essay
    public function jawabanEssay()
    {
        return $this->hasMany(JawabanSiswaEssay::class, 'hasil_ujian_id');
    }
}
