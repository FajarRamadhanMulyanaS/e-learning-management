<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArrayExport implements FromArray, WithHeadings, WithStyles
{
    protected $data;
    protected $headings;

    // Constructor sekarang bisa terima headings opsional
    public function __construct(array $data, array $headings = [])
    {
        $this->data = $data;
        $this->headings = $headings;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        // Kalau header dikirim dari controller → pakai itu
        // Kalau tidak → fallback ke default lama
        return $this->headings ?: ['No', 'Nama Siswa', 'Kelas', 'Mapel', 'Guru', 'Tanggal', 'Status'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
