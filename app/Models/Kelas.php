<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_kelas',
        'nama_kelas',
    ];

    public function GuruMapel()
    {
        return $this->hasOne(guru::class);
    }
    // Relasi ke Materi
    public function materi()
    {
        return $this->hasMany(Materi::class);
    }
    public function siswa()
    {
        return $this->hasMany(Siswa::class); // Setiap kelas memiliki banyak siswa
    }
    // Relasi ke users melalui tabel siswa
    public function users()
    {
        return $this->hasManyThrough(User::class, Siswa::class, 'kelas_id', 'id', 'id', 'user_id');
    }
    // Relasi ke Ujian
    public function ujians()
    {
        return $this->hasMany(Ujian::class, 'kelas_id');
    }
    public function videos()
    {
        return $this->hasMany(Video::class, 'kelas_id', 'kelas_id');
    }

}
