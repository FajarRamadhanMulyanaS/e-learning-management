<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengirim_id',
        'penerima_id',
        'judul',
        'isi_pesan',
        'is_read',
    ];

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }
    // Relasi ke tabel balasan_pesan
    public function balasan()
    {
        return $this->hasMany(BalasanPesan::class, 'pesan_id');
    }
}
