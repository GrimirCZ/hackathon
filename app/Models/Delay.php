<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delay extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'delay', 'start', 'end', 'connection_id'
    ];

    public function connection()
    {
        return $this->belongsTo(Connection::class);
    }
}
