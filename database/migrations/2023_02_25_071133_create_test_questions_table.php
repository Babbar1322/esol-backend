<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id');
            $table->unsignedBigInteger('test_group_id');
            $table->string('question_type');
            $table->string('question')->nullable();
            $table->integer('question_number');
            $table->string('question_hint', 1200)->nullable();
            $table->string('answer');
            $table->integer('q_count')->nullable();
            $table->unsignedBigInteger('dnd_id')->nullable();
            $table->integer('marks');
            $table->timestamps();
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
            $table->foreign('test_group_id')->references('id')->on('test_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_questions');
    }
}
