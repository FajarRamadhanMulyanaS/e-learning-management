<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('materi', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('file_path')->nullable();
        $table->unsignedBigInteger('guru_id');
        $table->unsignedBigInteger('kelas_id');
        $table->unsignedBigInteger('mapel_id');
        $table->foreign('guru_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
        $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
