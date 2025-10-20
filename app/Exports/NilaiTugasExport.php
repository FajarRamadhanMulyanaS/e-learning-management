<?php
namespace App\Exports;

use App\Models\PengumpulanTugas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NilaiTugasExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tugasId;

    public function __construct($tugasId)
    {
        $this->tugasId = $tugasId;
    }

    public function collection()
    {
        return PengumpulanTugas::where('tugas_id', $this->tugasId)->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Komentar',
            'Nilai',
            'Tanggal Pengumpulan',
        ];
    }

    public function map($pengumpulan): array
    {
        return [
            $pengumpulan->id,
            $pengumpulan->siswa->username ?? 'Tidak ada',
            $pengumpulan->komentar ?? '-',
            $pengumpulan->nilai ?? 'Belum Dinilai',
            $pengumpulan->created_at ? $pengumpulan->created_at->format('d-m-Y H:i') : '-',
        ];
    }
}
