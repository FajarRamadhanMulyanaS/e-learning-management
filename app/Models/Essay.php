<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Essay extends Model
{
    use HasFactory;

    protected $table = 'essay';
    protected $fillable = [
        'ujian_id',
        'soal',
        'tgl_buat'
    ];
    public $timestamps = true;
    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }
}
