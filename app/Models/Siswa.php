<?php

namespace App\Models;

// PASTIKAN KEDUA BARIS INI ADA
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// (Import model-model lain yang Anda perlukan)
use App\Models\User;
use App\Models\Kelas;
use App\Models\PengumpulanTugas;
use App\Models\HasilUjian;
use App\Models\QuizSubmission;
use App\Models\JawabanSiswaPilgan;
use App\Models\JawabanSiswaEssay;


class Siswa extends Model
{
    // PASTIKAN BARIS INI ADA
    use HasFactory;

    protected $table = 'siswa';
    protected $fillable = [
        'user_id', 'nis', 'nisn', 'telepon', 'alamat', 'tgl_lahir', 'kelas_id', 'gender',
    ];

    /**
     * Relasi ke model User (Login)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    /**
     * Relasi ke Kelas (SUMBER KEBENARAN)
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // --- SEMUA RELASI NILAI HARUS ADA DI SINI ---

    /**
     * Relasi ke Pengumpulan Tugas (via siswa_id)
     */
    public function pengumpulanTugas()
    {
        // Ganti 'App\Models\PengumpulanTugas' jika nama model Anda berbeda
        return $this->hasMany(PengumpulanTugas::class, 'siswa_id');
    }

    /**
     * Relasi ke Hasil Ujian (via siswa_id)
     */
    public function hasilUjian()
    {
        // Ganti 'App\Models\HasilUjian' jika nama model Anda berbeda
        return $this->hasMany(HasilUjian::class, 'siswa_id');
    }

    /**
     * Relasi ke Pengumpulan Quiz (via siswa_id)
     * (INI PINDAHAN DARI MODEL USER SETELAH LANGKAH 3)
     */
    public function quizSubmissions()
    {
        // Ganti 'App\Models\QuizSubmission' jika nama model Anda berbeda
        return $this->hasMany(QuizSubmission::class, 'siswa_id');
    }
    
    // Relasi-relasi lain yang terkait 'siswa_id'
    public function jawabanPilgan()
    {
        return $this->hasMany(JawabanSiswaPilgan::class, 'siswa_id');
    }

    public function jawabanEssay()
    {
        return $this->hasMany(JawabanSiswaEssay::class, 'siswa_id');
    }

    // Hapus method hasCompletedPilihanGanda dan hasCompletedEssay jika tidak terpakai
    // ...
}

