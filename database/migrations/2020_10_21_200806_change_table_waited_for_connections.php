<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTableWaitedForConnections extends Migration
{
    public function up()
    {
        Schema::table('waited_for_connections', function(Blueprint $table){
            $table->renameColumn("waits_in", "station");
            $table->renameColumn("waits_for_minutes", "minutes");
            //
        });
    }

    public function down()
    {
        Schema::table('waited_for_connections', function(Blueprint $table){
            //
        });
    }
}
