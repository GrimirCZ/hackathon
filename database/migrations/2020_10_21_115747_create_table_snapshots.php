<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSnapshots extends Migration
{
    public function up()
    {
        Schema::create('snapshots', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->foreignId("connection_id")->constrained()->onDelete("cascade");

            $table->float("lat", 8, 6);
            $table->float("lon", 8, 6);

            $table->datetime("time");
            $table->integer("delay")->nullable();

            $table->datetime("depart_time");
            $table->datetime("dest_time");

            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('snapshots');
    }
}
