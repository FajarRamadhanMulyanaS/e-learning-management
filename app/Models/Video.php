<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'mapel_id',
        'kelas_id',
        'file_path',
        'link_youtube',
    ];
    public function mapel()
{
    return $this->belongsTo(Mapel::class, 'mapel_id');
}

public function kelas()
{
    return $this->belongsTo(Kelas::class, 'kelas_id');
}
}
