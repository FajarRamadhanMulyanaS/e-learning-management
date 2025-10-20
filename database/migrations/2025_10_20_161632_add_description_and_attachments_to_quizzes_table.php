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
        Schema::table('quizzes', function (Blueprint $table) {
            // Tambahkan kolom baru hanya jika belum ada
            if (!Schema::hasColumn('quizzes', 'description')) {
                $table->text('description')->nullable()->after('judul');
            }
            if (!Schema::hasColumn('quizzes', 'attachment_file')) {
                $table->string('attachment_file')->nullable()->after('description');
            }
            if (!Schema::hasColumn('quizzes', 'attachment_link')) {
                $table->string('attachment_link')->nullable()->after('attachment_file');
            }
            if (!Schema::hasColumn('quizzes', 'attachment_image')) {
                $table->string('attachment_image')->nullable()->after('attachment_link');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            // Hapus kolom jika rollback dijalankan
            if (Schema::hasColumn('quizzes', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('quizzes', 'attachment_file')) {
                $table->dropColumn('attachment_file');
            }
            if (Schema::hasColumn('quizzes', 'attachment_link')) {
                $table->dropColumn('attachment_link');
            }
            if (Schema::hasColumn('quizzes', 'attachment_image')) {
                $table->dropColumn('attachment_image');
            }
        });
    }
};
