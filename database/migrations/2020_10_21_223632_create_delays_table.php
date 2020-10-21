<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelaysTable extends Migration
{
    public function up()
    {
        Schema::create('delays', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->integer("delay");

            $table->dateTime("start");
            $table->dateTime("end");

            $table->foreignId("connection_id")->constrained();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delays');
    }
}
