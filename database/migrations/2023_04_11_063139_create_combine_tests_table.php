<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCombineTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combine_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reading_test_id')->nullable();
            $table->unsignedBigInteger('listening_test_id')->nullable();
            $table->unsignedBigInteger('writing_test_id')->nullable();
            // $table->string('reading_test_name')->nullable();
            // $table->string('listening_test_name')->nullable();
            // $table->string('writing_test_name')->nullable();
            $table->string('name')->nullable();
            // relation with test table
            $table->foreign('reading_test_id')->references('id')->on('tests')->onDelete('cascade');
            $table->foreign('listening_test_id')->references('id')->on('tests')->onDelete('cascade');
            $table->foreign('writing_test_id')->references('id')->on('tests')->onDelete('cascade');
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
        Schema::dropIfExists('combine_tests');
    }
}
