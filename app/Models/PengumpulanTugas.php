<?php

// app/Models/PengumpulanTugas.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    use HasFactory;
    protected $table = 'pengumpulan_tugas';
    protected $fillable = ['tugas_id', 'siswa_id', 'file_tugas','nilai', 'komentar'];

    /**
     * Relasi ke model Tugas
     */
    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    /**
     * Relasi ke model Siswa (YANG BENAR)
     * Kolom 'siswa_id' di tabel ini merujuk ke 'id' di tabel 'siswa'.
     */
    public function siswa()
    {
        // !! PERBAIKAN DI SINI !! Ganti User::class menjadi Siswa::class
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
