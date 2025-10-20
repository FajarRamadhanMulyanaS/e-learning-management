<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswaPilgan extends Model
{
    protected $table = 'jawaban_siswa_pilgan';

    protected $fillable = [
        'siswa_id',
        'ujian_id',
        'pilihan_ganda_id',
        'jawaban_siswa',
        'nilai_pg'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }
}
