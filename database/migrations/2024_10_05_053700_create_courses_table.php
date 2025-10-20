<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama mata pelajaran
            $table->text('description')->nullable(); // Deskripsi mata pelajaran
            $table->unsignedBigInteger('teacher_id'); // ID guru (foreign key)
            $table->timestamps();

            // Definisikan foreign key untuk teacher_id yang berhubungan dengan tabel users
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
