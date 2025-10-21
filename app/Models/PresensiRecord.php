<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PresensiRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'presensi_session_id',
        'siswa_id',
        'status',
        'waktu_absen',
        'metode_absen',
        'keterangan',
    ];

    protected $casts = [
        'waktu_absen' => 'datetime',
    ];

    // Relasi ke PresensiSession
    public function presensiSession()
    {
        return $this->belongsTo(PresensiSession::class);
    }

    // Relasi ke Siswa (User)
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    // Scope untuk status tertentu
    public function scopeHadir($query)
    {
        return $query->where('status', 'hadir');
    }

    public function scopeTerlambat($query)
    {
        return $query->where('status', 'terlambat');
    }

    public function scopeTidakHadir($query)
    {
        return $query->where('status', 'tidak_hadir');
    }

    // Method untuk menentukan status berdasarkan waktu
    public function determineStatus($waktuAbsen, $jamMulai)
{
    $jamMulaiCarbon = Carbon::parse($jamMulai);
    $waktuAbsenCarbon = Carbon::parse($waktuAbsen);

    if ($waktuAbsenCarbon->greaterThan($jamMulaiCarbon->addMinutes(5))) {
        return 'terlambat';
    }

    return 'hadir';
}


    // Method untuk melakukan absen
    public function doAbsen($metodeAbsen = 'manual', $keterangan = null)
    {
        // Load presensi session jika belum di-load
        if (!$this->relationLoaded('presensiSession')) {
            $this->load('presensiSession');
        }

        // Tentukan status berdasarkan jam mulai saja
        $this->status = $this->determineStatus(now(), $this->presensiSession->jam_mulai);
        $this->waktu_absen = now();
        $this->metode_absen = $metodeAbsen;
        $this->keterangan = $keterangan;
        $this->save();

        return $this;
    }

    // Accessor untuk format waktu absen
    public function getWaktuAbsenFormattedAttribute()
    {
        return $this->waktu_absen ? $this->waktu_absen->format('H:i:s') : '-';
    }

    // Accessor untuk status dalam bahasa Indonesia
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'tidak_hadir' => 'Tidak Hadir',
            default => 'Tidak Hadir'
        };
    }

    // Accessor untuk badge class berdasarkan status
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'hadir' => 'badge-success',
            'terlambat' => 'badge-warning',
            'tidak_hadir' => 'badge-danger',
            default => 'badge-secondary'
        };
    }
}
