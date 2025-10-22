<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_tugas';

    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'file_tugas',
        'nilai',
        'komentar',
    ];

    // ============================================================
    // 🔗 RELASI ANTAR MODEL
    // ============================================================

    /**
     * Relasi ke tabel Tugas
     * Setiap pengumpulan terkait dengan 1 tugas
     */
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    /**
     * Relasi ke tabel Siswa
     * Setiap pengumpulan dilakukan oleh 1 siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Relasi tidak langsung ke tabel User (melalui Siswa)
     * Berguna untuk menampilkan nama siswa dari tabel users
     */
    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Siswa::class,
            'id',        // Foreign key di tabel siswa
            'id',        // Foreign key di tabel users
            'siswa_id',  // Foreign key di tabel pengumpulan_tugas
            'user_id'    // Foreign key di tabel siswa
        );
    }
}
