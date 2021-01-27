<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Snapshot */
class SnapshotResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'lat' => $this->lat,
            'lon' => $this->lon,

            'time' => $this->time, 'delay' => $this->delay,

            'depart_time' => $this->depart_time, 'dest_time' => $this->dest_time,

        ];
    }
}
