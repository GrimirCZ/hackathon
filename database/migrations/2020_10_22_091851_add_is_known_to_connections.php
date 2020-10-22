<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsKnownToConnections extends Migration
{
    public function up()
    {
        Schema::table('connections', function(Blueprint $table){
            $table->boolean("is_known")->default(true);
            $table->string('from')->nullable()->change();
            $table->string('to')->nullable()->change();
            //
        });
    }

    public function down()
    {
        Schema::table('connections', function(Blueprint $table){
            //
        });
    }
}
