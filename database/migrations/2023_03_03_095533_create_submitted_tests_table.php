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
            $table->unsignedBigInteger('test_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('question_id')->nullable();
            $table->unsignedBigInteger('allocated_test_id')->nullable();
            $table->integer('question_number')->nullable();
            $table->string('question_type')->nullable();
            $table->text('question_value')->nullable();
            $table->boolean('is_correct');
            $table->integer('marks')->nullable();
            $table->boolean('is_checked')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
