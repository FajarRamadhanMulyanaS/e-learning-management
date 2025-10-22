<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    protected $table = 'ujian'; // nama tabel

    protected $fillable = [
        'judul',
        'mapel_id',
        'kelas_id',
        'waktu_pengerjaan',
        'info_ujian',
        'bobot_pilihan_ganda',
        'bobot_essay',
        'terbit',

        'user_id' // Tambahkan ini
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke model Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    // Relasi ke model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    // Relasi ke model User (Guru)
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'user_id'); // guru_id adalah foreign key yang merujuk ke tabel users
    }
    // Relasi dengan soal pilihan ganda
    public function pilihanGanda()
    {
        return $this->hasMany(PilihanGanda::class, 'ujian_id');
    }
    public function soal()
{
    return $this->hasMany(PilihanGanda::class, 'ujian_id', 'id');
}

    // Relasi ke Soal Essay
    public function essay()
    {
        return $this->hasMany(Essay::class, 'ujian_id');
    }
    public function jawabanEssay()
{
    return $this->hasMany(JawabanSiswaEssay::class, 'ujian_id');
}

    // Relasi ke HasilUjian
    public function hasilUjian()
    {
        return $this->hasMany(HasilUjian::class, 'ujian_id');
    }
}
