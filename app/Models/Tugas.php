<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'judul',
        'deskripsi',
        'file',
        'mapel_id',
        'kelas_id',
        'guru_id',
        'tanggal_pengumpulan',
        'answer_visible_to_others',
    ];

    protected $casts = [
        'tanggal_pengumpulan' => 'datetime',
    ];

    // ============================================================
    // 🔗 RELASI ANTAR MODEL
    // ============================================================

    /**
     * Relasi ke tabel Mapel (mata pelajaran)
     * Setiap tugas milik 1 mapel
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    /**
     * Relasi ke tabel User sebagai guru
     * Kolom foreign key: guru_id
     */
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    /**
     * Relasi ke tabel Kelas
     * Setiap tugas hanya untuk 1 kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi ke tabel PengumpulanTugas
     * Satu tugas bisa dikumpulkan oleh banyak siswa
     */
    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'tugas_id');
    }
}
