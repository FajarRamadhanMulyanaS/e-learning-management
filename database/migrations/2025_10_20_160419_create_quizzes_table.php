<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            
            // Foreign key ke tabel guru_mapels
            $table->foreignId('guru_mapel_id')
                  ->constrained('guru_mapels')
                  ->onDelete('cascade');
            
            $table->text('description')->nullable();
            $table->string('attachment_file')->nullable();
            $table->string('attachment_link')->nullable();
            $table->string('attachment_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};