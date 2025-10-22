<?php

namespace App\Models; // <-- Pastikan namespace Anda adalah App\Models

// -----------------------------------------------------------------
// PERBAIKAN: Menambahkan 'use' statement untuk HasFactory dan Notifiable
// Ini akan memperbaiki error 'Trait not found'
// -----------------------------------------------------------------
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Import model-model yang direlasikan
use App\Models\Siswa;
use App\Models\Guru; // (Sesuaikan jika nama model Anda 'guru' huruf kecil)
use App\Models\GuruMapel; // (Sesuaikan jika nama model Anda 'gurumapel')
// use App\Models\PresensiRecord; // Dihapus karena fitur presensi dihilangkan

class User extends Authenticatable
{
    // Baris ini sekarang akan berfungsi
    use HasFactory, Notifiable;

    /**
     * Fungsi untuk cek role
     */
    public function isAdmin() { return $this->role === 'admin'; }
    public function isGuru() { return $this->role === 'guru'; }
    public function isSiswa() { return $this->role === 'siswa'; }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'username', 'email', 'password', 'role' // <-- 'kelas_id' sudah dihapus (Langkah 2)
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELASI YANG BENAR (YANG TERSISA DI USER) ---

    public function guru()
    {
        // Ganti 'Guru::class' dengan 'guru::class' jika nama file Anda 'guru.php'
        return $this->hasOne(Guru::class, 'user_id');
    }

    public function GuruMapel()
    {
        // Ganti 'GuruMapel::class' dengan 'gurumapel::class' jika nama file Anda 'gurumapel.php'
        return $this->hasOne(GuruMapel::class, 'user_id');
    }

    /**
     * Relasi ke tabel siswa (INI PENTING)
     */
    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id');
    }


    // --- RELASI YANG SUDAH DIHAPUS/DIPINDAH ---
    //
    // public function kelas() { ... } // <-- DIHAPUS (pindah ke Siswa.php & dihapus dari DB users)
    // public function jawabanSiswaPilgan() { ... } // <-- DIHAPUS (pindah ke Siswa.php)
    // public function jawabanSiswaEssay() { ... } // <-- DIHAPUS (pindah ke Siswa.php)
    // public function quizSubmissions() { ... } // <-- DIHAPUS (pindah ke Siswa.php)
    // public function presensiRecords() { ... } // <-- DIHAPUS (fitur laporan presensi dihilangkan)
    //
}

