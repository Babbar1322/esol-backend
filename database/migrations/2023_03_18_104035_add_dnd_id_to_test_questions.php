<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDndIdToTestQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_questions', function (Blueprint $table) {
            // $table->integer('dnd_id')->after('answer');
            $table->unsignedBigInteger('dnd_id')->after('answer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_questions', function (Blueprint $table) {
            $table->dropColumn('dnd_id')->after('answer');
        });
    }
}
