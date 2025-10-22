<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi (mass assignable)
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'foto',
        'kelas_id',
        'role',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tipe casting atribut
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ============================================================
    // 🔐 ROLE CHECKING
    // ============================================================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    // ============================================================
    // 🔗 RELASI ANTAR MODEL
    // ============================================================

    /**
     * Relasi ke tabel guru (1 user = 1 guru)
     */
    public function guru()
    {
        return $this->hasOne(Guru::class, 'user_id');
    }

    /**
     * Relasi ke tabel guru_mapel (1 user = 1 mapel guru)
     */
    public function guruMapel()
    {
        return $this->hasOne(GuruMapel::class, 'user_id');
    }

    /**
     * Relasi ke tabel kelas
     * (1 user hanya bisa memiliki 1 kelas)
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi ke tabel siswa (1 user hanya punya 1 data siswa)
     */
    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id');
    }

    /**
     * Relasi ke tabel pengumpulan_tugas melalui siswa
     */
    public function pengumpulanTugas()
    {
        return $this->hasManyThrough(
            PengumpulanTugas::class, // tabel tujuan akhir
            Siswa::class,            // tabel perantara
            'user_id',               // foreign key di tabel siswa
            'siswa_id',              // foreign key di tabel pengumpulan_tugas
            'id',                    // primary key di tabel users
            'id'                     // primary key di tabel siswa
        );
    }

    /**
     * Relasi ke tabel presensi_record
     */
    public function presensiRecords()
    {
        return $this->hasMany(PresensiRecord::class, 'user_id');
    }

    /**
     * Relasi ke hasil ujian (melalui siswa)
     */
    public function hasilUjian()
    {
        return $this->hasManyThrough(
            HasilUjian::class,
            Siswa::class,
            'user_id',   // Foreign key di tabel siswa
            'siswa_id',  // Foreign key di tabel hasil_ujian
            'id',        // Primary key di tabel users
            'id'         // Primary key di tabel siswa
        );
    }

    /**
     * Relasi ke quiz submissions (langsung)
     */
    public function quizSubmissions()
    {
        return $this->hasMany(QuizSubmission::class, 'user_id');
    }
}
