<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $fillable = [
        'user_id',
        'nip',
        'alamat',
        'tgl_lahir',
        'telepon',
        'gender',
        'jabatan',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Materi (sebagai pengunggah materi)
    public function materi()
    {
        return $this->hasMany(Materi::class);
    }

    public function ujian()
    {
        return $this->hasMany(Ujian::class);
    }
}
