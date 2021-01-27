<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFuunctionalIndexToConnections extends Migration
{
    public function up()
    {
//        Schema::table('connections', function(Blueprint $table){

//        });
        DB::unprepared("ALTER TABLE connections ADD INDEX `normalized-connection-name` ((LOWER(REPLACE(`name`, ' ', ''))));");
    }

    public function down()
    {
        Schema::table('connections', function(Blueprint $table){
            $table->dropIndex("normalized-connection-name");
            //
        });
    }
}
