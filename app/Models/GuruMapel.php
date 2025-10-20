<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'mapel_id', 'kelas_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id'); // Pastikan foreign key sesuai
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Pastikan foreign key sesuai
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id'); // Pastikan foreign key sesuai
    }
}
