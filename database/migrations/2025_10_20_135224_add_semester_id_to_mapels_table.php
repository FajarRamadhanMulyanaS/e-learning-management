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
        Schema::table('mapels', function (Blueprint $table) {
            $table->unsignedBigInteger('semester_id')->nullable()->after('id');
    
            // Jika ada relasi ke tabel semesters:
            // $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::table('mapels', function (Blueprint $table) {
            $table->dropColumn('semester_id');
        });
    }
    
};
