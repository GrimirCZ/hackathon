<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $fillable = [
        'id', 'identifier', 'name',
        'vehicle_type',

        'train_number', 'line_number', 'service_number',

        'is_known',

        'from', 'to',
        'operator'
    ];

    public function snapshots()
    {
        return $this->hasMany(Snapshot::class);
    }

    public function delays()
    {
        return $this->hasMany(Delay::class);
    }


    public function waits_for()
    {
        return $this->belongsToMany(Connection::class, "waited_for_connections", "awaiter_id", "awaited_for_id");
    }

    public function awaited_for_by()
    {
        return $this->belongsToMany(Connection::class, "waited_for_connections", "awaited_for_id", "awaiter_id");
    }
}
