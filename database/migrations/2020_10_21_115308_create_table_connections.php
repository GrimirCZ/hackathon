<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableConnections extends Migration
{
    public function up()
    {
        Schema::create('connections', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("identifier")->unique();
            $table->string("name");
            // A -> autobus, V -> vlak?
            $table->string("vehicle_type");

            $table->string("train_number")->nullable();
            $table->string("line_number")->nullable();
            $table->string("service_number")->nullable();

            $table->string("from");
            $table->string("to");

            $table->string("operator");
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('connections');
    }
}
