<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semesters = [
            [
                'nama_semester' => 'Semester 1 (Ganjil)',
                'tahun_ajaran' => '2024/2025',
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2024-12-20',
                'is_active' => true,
                'deskripsi' => 'Semester ganjil tahun ajaran 2024/2025',
            ],
            [
                'nama_semester' => 'Semester 2 (Genap)',
                'tahun_ajaran' => '2024/2025',
                'tanggal_mulai' => '2025-01-06',
                'tanggal_selesai' => '2025-06-20',
                'is_active' => false,
                'deskripsi' => 'Semester genap tahun ajaran 2024/2025',
            ],
            [
                'nama_semester' => 'Semester 1 (Ganjil)',
                'tahun_ajaran' => '2023/2024',
                'tanggal_mulai' => '2023-07-15',
                'tanggal_selesai' => '2023-12-20',
                'is_active' => false,
                'deskripsi' => 'Semester ganjil tahun ajaran 2023/2024',
            ],
            [
                'nama_semester' => 'Semester 2 (Genap)',
                'tahun_ajaran' => '2023/2024',
                'tanggal_mulai' => '2024-01-06',
                'tanggal_selesai' => '2024-06-20',
                'is_active' => false,
                'deskripsi' => 'Semester genap tahun ajaran 2023/2024',
            ],
        ];

        foreach ($semesters as $semester) {
            Semester::create($semester);
        }
    }
}
