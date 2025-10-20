<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom untuk diisi (alternatif dari $fillable)
    protected $guarded = ['id'];

    /**
     * Method ini mendefinisikan bahwa sebuah Attachment
     * bisa dimiliki oleh model lain (Thread atau Comment).
     */
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}