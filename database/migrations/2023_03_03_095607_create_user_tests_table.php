<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tests', function (Blueprint $table) {
            $table->id();
            // $table->integer('user_id');
            // $table->integer('test_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('test_id');
            $table->integer('start_time');
            $table->integer('total_questions');
            $table->string('total_score')->nullable();
            $table->string('status')->default('pending');
            $table->string('submit_time');
            $table->string('time_taken')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_tests');
    }
}
