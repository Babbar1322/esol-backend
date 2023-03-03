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
            $table->integer('test_id');
            $table->integer('user_id');
            $table->integer('question_id');
            $table->integer('question_number');
            $table->string('question_type');
            $table->string('question_value');
            $table->string('time_taken');
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
        Schema::dropIfExists('submitted_tests');
    }
}
