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

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');// Gantilah 'kelas_id' sesuai dengan nama kolom di tabel siswa yang merujuk ke kelas
    }
    // Relasi ke JawabanSiswaPilgan
    public function jawabanPilgan()
    {
        return $this->hasMany(JawabanSiswaPilgan::class, 'siswa_id');
    }

    // Method untuk mengecek apakah siswa sudah menyelesaikan pilihan ganda
    public function hasCompletedPilihanGanda($ujianId)
    {
        // Cek apakah ada jawaban yang disimpan untuk ujian ini
        return $this->jawabanPilgan()->where('ujian_id', $ujianId)->exists();
    }
    // Relasi ke jawaban essay (asumsi Anda punya model JawabanSiswaEssay)
    public function jawabanEssay()
    {
        return $this->hasMany(JawabanSiswaEssay::class, 'siswa_id');
    }

    // Method untuk mengecek apakah siswa sudah menyelesaikan essay
    public function hasCompletedEssay($ujianId)
    {
        // Cek apakah ada jawaban essay yang disimpan untuk ujian ini
        return $this->jawabanEssay()->where('ujian_id', $ujianId)->exists();
    }

}
