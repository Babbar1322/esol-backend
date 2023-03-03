<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTimeTakenFromSubmittedTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('submitted_tests', 'time_taken')) {
            Schema::table('submitted_tests', function (Blueprint $table) {
                $table->dropColumn('time_taken');
            });
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('submitted_tests', function (Blueprint $table) {
            if (Schema::hasColumn('submitted_tests', 'time_taken')) {
                Schema::table('submitted_tests', function (Blueprint $table) {
                    $table->dropColumn('time_taken');
                });
            };
        });
    }
}
