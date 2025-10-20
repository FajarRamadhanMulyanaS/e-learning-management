<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_semester',
        'tahun_ajaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean',
    ];

    // Relasi dengan Mapel
    public function mapels()
    {
        return $this->hasMany(Mapel::class);
    }

    // Relasi dengan Ujian
    public function ujians()
    {
        return $this->hasMany(Ujian::class);
    }

    // Relasi dengan Materi
    public function materis()
    {
        return $this->hasMany(Materi::class);
    }

    // Scope untuk semester aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor untuk nama lengkap semester
    public function getNamaLengkapAttribute()
    {
        return $this->nama_semester . ' ' . $this->tahun_ajaran;
    }

    // Method untuk mengaktifkan semester (nonaktifkan yang lain)
    public function activate()
    {
        // Nonaktifkan semua semester
        self::query()->update(['is_active' => false]);
        
        // Aktifkan semester ini
        $this->update(['is_active' => true]);
    }
}
