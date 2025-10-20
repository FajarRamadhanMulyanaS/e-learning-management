<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    // Kolom yang diizinkan untuk mass assignment
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
    ];

    public function GuruMapel()
    {
        return $this->hasOne(guru::class);
    }
    public function videos()
    {
        return $this->hasMany(Video::class, 'mapel_id');
    }
    // Relasi ke Materi
    public function materi()
    {
        return $this->hasMany(Materi::class);
    }
    // Relasi ke Ujian
    public function ujians()
    {
        return $this->hasMany(Ujian::class, 'mapel_id');
    }
}
