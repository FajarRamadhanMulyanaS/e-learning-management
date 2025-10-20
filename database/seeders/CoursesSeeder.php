<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Faker\Factory as Faker;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Ambil ID guru dari tabel users yang memiliki role 'guru'
        $users = DB::table('users')->where('role', 'guru')->pluck('id')->toArray();

        // Cek jika ada guru yang tersedia
        if (empty($users)) {
            Log::warning('Tidak ada guru yang ditemukan untuk mengisi teacher_id di tabel courses.');
            return;
        }

        // Buat 10 data acak untuk mata pelajaran
        foreach (range(1, 10) as $index) {
            DB::table('courses')->insert([
                'name' => 'Mata Pelajaran ' . $index, // Nama mata pelajaran
                'description' => $faker->sentence(10), // Deskripsi acak
                'users_id' => $faker->randomElement($users), // ID guru diambil dari data guru yang ada
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
