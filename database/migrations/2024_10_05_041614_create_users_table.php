<?php

//User

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('username')->unique();  // Username yang unik
            $table->string('email')->unique();  // Email yang unik
            $table->string('password');  // Password
            $table->string('role');  // Role: admin, guru, siswa
            $table->timestamps();  // Kolom created_at dan updated_at
        });
    }

    /**
     * Balikkan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
