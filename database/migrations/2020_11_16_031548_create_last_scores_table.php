<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLastScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('last_scores', function (Blueprint $table) {
            $table->bigInteger('item_id')->unique();
            $table->string('z1');
            $table->string('z2');
            $table->string('z3');
            $table->string('z4');
            $table->string('z5');
            $table->string('z6');
            $table->string('z7');
            $table->string('last_score');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('last_scores');
    }
}
