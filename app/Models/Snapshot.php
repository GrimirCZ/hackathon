<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Snapshot extends Model
{
    protected $fillable = [
        'lat', 'lon',

        'time', 'delay',

        'depart_time', 'dest_time',

        'is_old',

        'connection_id'
    ];

    public function connection()
    {
        return $this->belongsTo(Connection::class);
    }
}
