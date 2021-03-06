<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token')->unique()->nullable();
            $table->boolean('complete_modals')->default(false);
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('session_id')->references('id')->on('exam_sessions')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->unique(['session_id', 'teacher_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_teachers');
    }
}
