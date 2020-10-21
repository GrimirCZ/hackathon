<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsOldToSnapshots extends Migration
{
    public function up()
    {
        Schema::table('snapshots', function(Blueprint $table){
            $table->boolean("is_old")->default(false);
            //
        });
    }

    public function down()
    {
        Schema::table('snapshots', function(Blueprint $table){
            //
        });
    }
}
