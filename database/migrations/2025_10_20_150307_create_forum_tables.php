<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        /*
        // DINONAKTIFKAN KARENA TABEL SUDAH ADA
        // Tabel untuk Threads
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('content');
            $table->timestamps();
        });

        // DINONAKTIFKAN KARENA TABEL SUDAH ADA
        // Tabel untuk Komentar
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('thread_id')->constrained('threads')->cascadeOnDelete();
            $table->text('content');
            $table->timestamps();
        });
        */

        // HANYA BAGIAN INI YANG AKAN DIJALANKAN
        // Tabel untuk Lampiran (Polymorphic)
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('filename'); // Nama asli file
            $table->string('path');     // Path file di storage
            $table->morphs('attachable'); // Membuat kolom attachable_id dan attachable_type
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
        
        // Schema::dropIfExists('comments'); // Dinonaktifkan
        // Schema::dropIfExists('threads');  // Dinonaktifkan
    }
};