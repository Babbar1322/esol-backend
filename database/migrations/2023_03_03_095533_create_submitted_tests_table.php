<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmittedTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submitted_tests', function (Blueprint $table) {
            $table->id();
            // $table->integer('test_id');
            // $table->integer('user_id');
            // $table->integer('question_id');
            $table->unsignedBigInteger('test_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('question_id');
            $table->integer('question_number');
            $table->string('question_type');
            $table->string('question_value');
            $table->integer('is_correct');
            $table->timestamps();
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('test_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submitted_tests');
    }
}
