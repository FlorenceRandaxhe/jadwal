<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('session_id');
            $table->string('courses');
            $table->string('groups');
            $table->string('exam_type');
            $table->string('local');
            $table->string('exam_duration');
            $table->string('supervisor')->nullable();
            $table->text('requests')->nullable();
            $table->timestamps();
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('session_id')->references('id')->on('exam_sessions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modals');
    }
}
