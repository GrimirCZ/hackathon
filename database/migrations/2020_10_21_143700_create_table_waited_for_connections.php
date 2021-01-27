<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWaitedForConnections extends Migration
{
    public function up()
    {
        Schema::create('waited_for_connections', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->foreignId("awaiter_id")->constrained("connections");
            $table->foreignId("awaited_for_id")->constrained("connections");

            $table->integer("waits_for_minutes")->nullable();
            $table->string("waits_in")->nullable();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waited_for_connections');
    }
}
