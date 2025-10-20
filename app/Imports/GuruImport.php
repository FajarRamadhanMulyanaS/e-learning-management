<?php
namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class GuruImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row)
        {
            // Skip the first row (header)
            if ($key == 0) {
                continue;
            }

            // Cek apakah username dan nip sudah ada
            if (!isset($row[1]) || empty($row[1])) {
                // Jika username kosong, lewati baris ini
                continue;
            }

            if (Guru::where('nip', $row[0])->exists()) {
                // Skip jika NIP sudah ada
                continue;
            }

            // Convert tgl_lahir to Carbon instance if valid, or set null if invalid
            $tgl_lahir = null;
            if (isset($row[6]) && !empty($row[6])) {
                try {
                    // Parsing tanggal lahir, asumsi format input Excel adalah standar (YYYY-MM-DD atau lainnya)
                    $tgl_lahir = Carbon::parse($row[6])->format('Y-m-d');
                } catch (\Exception $e) {
                    // Jika parsing gagal, biarkan null
                    $tgl_lahir = null;
                }
            }

            // Create user for each guru
            $user = User::create([
                'username' => $row[1], // Kolom username di Excel
                'password' => bcrypt('123456'), // Password default
                'role' => 'guru',
            ]);

            // Create guru record
            Guru::create([
                'user_id' => $user->id, // Hubungkan dengan user yang baru dibuat
                'nip' => $row[0], // Kolom NIP di Excel
                'telepon' => $row[2], // Kolom Telepon di Excel
                'gender' => $row[3], // Kolom Gender di Excel
                'alamat' => $row[4], // Kolom Alamat di Excel
                'jabatan' => $row[5], // Kolom Jabatan di Excel
                'tgl_lahir' => $tgl_lahir, // Kolom Tanggal Lahir di Excel (format Y-m-d)
            ]);
        }
    }
}
