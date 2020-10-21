<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $fillable = [
        'id', 'identifier', 'name',
        'vehicle_type',

        'train_number', 'line_number', 'service_number',

        'from', 'to',
        'operator'
    ];

    public function snapshots()
    {
        return $this->hasMany(Snapshot::class);
    }
}
