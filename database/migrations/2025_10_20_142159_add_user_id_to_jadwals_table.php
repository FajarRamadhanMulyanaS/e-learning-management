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
        Schema::table('jadwal', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('mapel_id');
    
            // opsional: kalau relasi ke users
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    
    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
    
};
