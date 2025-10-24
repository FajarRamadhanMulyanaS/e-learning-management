<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanNilaiExport implements FromView, WithTitle, ShouldAutoSize
{
    protected $daftarSiswa;
    protected $kelas;
    protected $mapel;

    /**
     * Terima data dari Controller
     */
    public function __construct($daftarSiswa, $kelas, $mapel)
    {
        $this->daftarSiswa = $daftarSiswa;
        $this->kelas = $kelas;
        $this->mapel = $mapel;
    }

    /**
     * Render view blade
     */
    public function view(): View
    {
        // Arahkan ke file view blade BARU yang akan kita buat selanjutnya
        return view('admin.laporan.export_excel_view', [
            'daftarSiswa' => $this->daftarSiswa,
            'kelas'       => $this->kelas,
            'mapel'       => $this->mapel
        ]);
    }

    /**
     * Beri nama pada Sheet Excel
     */
    public function title(): string
    {
        return 'Laporan ' . $this->kelas->nama_kelas;
    }
}