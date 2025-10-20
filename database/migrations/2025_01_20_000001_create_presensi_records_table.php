<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('presensi_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('presensi_session_id');
            $table->unsignedBigInteger('siswa_id');
            $table->enum('status', ['hadir', 'terlambat', 'tidak_hadir'])->default('tidak_hadir');
            $table->timestamp('waktu_absen')->nullable();
            $table->enum('metode_absen', ['qr', 'manual'])->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('presensi_session_id')->references('id')->on('presensi_sessions')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['presensi_session_id', 'siswa_id']);
            $table->index(['siswa_id', 'status']);
            $table->index(['presensi_session_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi_records');
    }
};
