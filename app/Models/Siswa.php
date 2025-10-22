<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'telepon',
        'alamat',
        'tgl_lahir',
        'kelas_id',
        'gender',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi ke model Kelas
     * (1 siswa hanya berada di 1 kelas)
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi ke model PengumpulanTugas
     * (1 siswa bisa mengumpulkan banyak tugas)
     */
    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'siswa_id');
    }

    /**
     * Relasi ke jawaban pilihan ganda
     */
    public function jawabanPilgan()
    {
        return $this->hasMany(JawabanSiswaPilgan::class, 'siswa_id');
    }

    /**
     * Relasi ke jawaban essay
     */
    public function jawabanEssay()
    {
        return $this->hasMany(JawabanSiswaEssay::class, 'siswa_id');
    }

    // ============================================================
    // ⚙️ METHOD TAMBAHAN UNTUK CEK STATUS UJIAN
    // ============================================================

    /**
     * Mengecek apakah siswa sudah menyelesaikan ujian pilihan ganda
     */
    public function hasCompletedPilihanGanda($ujianId)
    {
        return $this->jawabanPilgan()
            ->where('ujian_id', $ujianId)
            ->exists();
    }

    /**
     * Mengecek apakah siswa sudah menyelesaikan ujian essay
     */
    public function hasCompletedEssay($ujianId)
    {
        return $this->jawabanEssay()
            ->where('ujian_id', $ujianId)
            ->exists();
    }

    public function hasilUjian()
    {
        return $this->hasMany(HasilUjian::class, 'siswa_id');
    }

    public function quizSubmissions()
    {
        return $this->hasManyThrough(
            QuizSubmission::class,
            User::class,
            'id',        // Foreign key di tabel users
            'user_id',  // Foreign key di tabel quiz_submissions
            'user_id',  // Foreign key di tabel siswa
            'id'        // Primary key di tabel users
        );
    }
}
