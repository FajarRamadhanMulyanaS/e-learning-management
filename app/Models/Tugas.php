<?php
// app/Models/Tugas.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'deskripsi','file', 'mapel_id', 'kelas_id', 'guru_id','tanggal_pengumpulan','answers_visible_to_others',];
    protected $casts = [
        'tanggal_pengumpulan' => 'datetime',
    ];
    // Di dalam model Tugas
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }
    // Relasi ke model Guru
    public function guru()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id');
    }

    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }
}
