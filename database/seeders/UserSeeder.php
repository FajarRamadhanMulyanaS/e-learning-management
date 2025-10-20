<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Insert data untuk pengguna dengan role admin
        // DB::table('users')->insert([
        //     'username' => 'admin',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'admin',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // // Insert data untuk pengguna dengan role guru
        // DB::table('users')->insert([
        //     'username' => 'guru_matematika',
        //     'email' => 'guru.matematika@smp.sch.id',
        //     'password' => Hash::make('123456'),
        //     'role' => 'guru',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);


        // Insert data acak untuk 5 siswa
        foreach (range(1, 5) as $index) {
            DB::table('users')->insert([
                'username' => 'siswa_' . $index,
                'email' => 'siswa' . $index . '@example.com',
                'password' => Hash::make('password123' . $index),
                'role' => 'siswa',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
