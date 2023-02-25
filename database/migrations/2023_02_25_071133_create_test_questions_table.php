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
            $table->integer('test_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->string('question_type');
            $table->string('question');
            $table->string('question_hint');
            $table->string('answer');
            $table->timestamps();
            $table->foreign('group_id')->references('id')->on('test_groups')->onDelete('cascade');
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
