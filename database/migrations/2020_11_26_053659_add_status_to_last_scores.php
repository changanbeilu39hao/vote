<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToLastScores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('last_scores', function (Blueprint $table) {
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('status2')->nullable();
            $table->tinyInteger('status3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('last_scores', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('status2');
            $table->dropColumn('status3');
        });
    }
}
