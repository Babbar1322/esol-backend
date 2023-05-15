<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllocatedTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocated_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('combined_test_id')->nullable();
            $table->unsignedBigInteger('reading_test_id')->nullable();
            $table->integer('reading_test_status')->default(0);
            $table->integer('reading_test_score')->default(0);
            $table->unsignedBigInteger('writing_test_id')->nullable();
            $table->integer('writing_test_status')->default(0);
            $table->integer('writing_test_score')->default(0);
            $table->unsignedBigInteger('listening_test_id')->nullable();
            $table->integer('listening_test_status')->default(0);
            $table->integer('listening_test_score')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('allocated_tests');
    }
}
