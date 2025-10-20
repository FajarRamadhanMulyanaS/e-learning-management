<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalasanPesan extends Model
{
    use HasFactory;
    protected $table= 'balasan_pesan';
    protected $fillable = [
        'pesan_id',
        'pengirim_id',
        'isi',
        'is_read',
    ];

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }
    public function pesan()
    {
        return $this->belongsTo(Pesan::class, 'pesan_id');
    }

}
