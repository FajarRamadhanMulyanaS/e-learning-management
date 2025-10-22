<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    use HasFactory;

    protected $table = 'hasil_ujian';

    protected $fillable = [
        'ujian_id',
        'siswa_id',
        'total_nilai_essay',
        'total_nilai_pilgan',
        'total_nilai',
    ];

    /**
     * Relasi ke tabel Ujian
     */
    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }

    /**
     * Relasi ke tabel Siswa (bukan User)
     * Karena di tabel hasil_ujian kolomnya siswa_id,
     * jadi harus mengarah ke model Siswa, bukan User
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Relasi ke jawaban pilihan ganda
     */
    public function jawabanPilgan()
    {
        return $this->hasMany(JawabanSiswaPilgan::class, 'hasil_ujian_id');
    }

    /**
     * Relasi ke jawaban essay
     */
    public function jawabanEssay()
    {
        return $this->hasMany(JawabanSiswaEssay::class, 'hasil_ujian_id');
    }
}
