<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSemesterToMapelsTable extends Migration
{
    public function up()
    {
        Schema::table('mapels', function (Blueprint $table) {
            $table->foreignId('semester_id')->nullable()->after('nama_mapel')->constrained('semesters')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('mapels', function (Blueprint $table) {
            $table->dropForeign(['semester_id']);
            $table->dropColumn('semester_id');
        });
    }
}
