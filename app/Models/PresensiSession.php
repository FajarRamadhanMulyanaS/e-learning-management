<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PresensiSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id',
        'mapel_id',
        'guru_id',
        'semester_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'mode',
        'qr_code',
        'qr_expires_at',
        'is_active',
        'is_closed',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
        'qr_expires_at' => 'datetime',
        'is_active' => 'boolean',
        'is_closed' => 'boolean',
    ];

    // Relasi ke Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi ke Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    // Relasi ke Guru (User)
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
    

    // Relasi ke Semester
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    // Relasi ke PresensiRecord
    public function presensiRecords()
    {
        return $this->hasMany(PresensiRecord::class);
    }

    // Scope untuk sesi aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('is_closed', false);
    }

    // Scope untuk sesi hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', today());
    }

    // Scope untuk kelas tertentu
    public function scopeForKelas($query, $kelasId)
    {
        return $query->where('kelas_id', $kelasId);
    }

    // Scope untuk guru tertentu
    public function scopeForGuru($query, $guruId)
    {
        return $query->where('guru_id', $guruId);
    }

    // Method untuk generate QR Code

    // Method untuk generate QR Code
    public function generateQRCode()
    {
        $this->qr_code = 'PRESENSI_' . $this->id . '_' . time() . '_' . rand(1000, 9999);
        $this->qr_expires_at = now()->endOfDay(); // QR berlaku hingga akhir hari ini
        $this->save();

        return $this->qr_code;
    }

    // Method untuk cek apakah QR masih berlaku
    public function isQRValid()
    {
        return $this->qr_code && $this->qr_expires_at && $this->qr_expires_at->isFuture();
    }

    // Method untuk menutup sesi
    public function closeSession()
    {
        $this->is_active = false;
        $this->is_closed = true;
        $this->save();
    }

    // Method untuk mendapatkan statistik presensi
    public function getPresensiStats()
    {
        // Hitung total siswa dari tabel siswa
        $totalSiswa = $this->kelas->siswa()->count();

        $hadir = $this->presensiRecords()->where('status', 'hadir')->count();
        $terlambat = $this->presensiRecords()->where('status', 'terlambat')->count();
        $tidakHadir = $totalSiswa - $hadir - $terlambat;

        return [
            'total_siswa' => $totalSiswa,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'tidak_hadir' => $tidakHadir,
            'persentase_hadir' => $totalSiswa > 0 ? round(($hadir + $terlambat) / $totalSiswa * 100, 2) : 0,
        ];
    }

    // Accessor untuk format waktu
    public function getJamMulaiFormattedAttribute()
    {
        return Carbon::parse($this->jam_mulai)->format('H:i');
    }

}
