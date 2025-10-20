<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'mapels';
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'users_id',
    ];

    // Definisikan relasi jika perlu
    public function guru()
{
    return $this->belongsTo(User::class, 'users_id');
}

}
