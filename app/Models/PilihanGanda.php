<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilihanGanda extends Model
{
    use HasFactory;

    protected $table = 'pilihan_ganda';  // Nama tabel di database
    protected $fillable = [
        'ujian_id',
        'soal',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'pilihan_e',
        'kunci_jawaban',
    ];

    // Relasi dengan ujian
    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }

}
