<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitedForConnections extends Model
{
    protected $fillable = [
        'minutes', 'station',
        'awaiter_id', 'awaited_for_id'
    ];

    public function awaiter()
    {
        return $this->belongsTo(Connection::class, 'awaiter_id');
    }

    public function awaited_for()
    {
        return $this->belongsTo(Connection::class, 'awaited_for_id');
    }
}
