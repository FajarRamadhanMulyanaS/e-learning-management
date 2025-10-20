<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Tambahkan atribut 'role' yang mengidentifikasi apakah pengguna admin, guru, atau siswa
    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function isGuru() {
        return $this->role === 'guru';
    }

    public function isSiswa() {
        return $this->role === 'siswa';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username', 'email', 'password','kelas_id', 'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',

    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function guru()
    {
        return $this->hasOne(guru::class);
    }
    public function GuruMapel()
    {
        return $this->hasOne(gurumapel::class);
    }
    // Relasi ke model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Relasi ke tabel siswa
    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id');
    }

    // Relasi ke jawaban pilihan ganda
    public function jawabanSiswaPilgan()
    {
        return $this->hasMany(JawabanSiswaPilgan::class, 'siswa_id');
    }

    // Relasi ke jawaban essay
    public function jawabanSiswaEssay()
    {
        return $this->hasMany(JawabanSiswaEssay::class, 'siswa_id');
    }
}
