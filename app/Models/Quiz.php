<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'guru_mapel_id',
        'description',
        'attachment_file',
        'attachment_link',
        'attachment_image',
    ];

    /**
     * Mendefinisikan relasi bahwa setiap Kuis "milik" satu GuruMapel.
     */
    public function guruMapel()
    {
        return $this->belongsTo(GuruMapel::class);
    }
}