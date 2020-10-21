<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Connection */
class ConnectionResource extends JsonResource
{
    public $collects = 'App\Http\Models\Connection';

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'identifier' => $this->identifier,
            'name' => $this->name,
            'vehicle_type' => $this->vehicle_type,

            'train_number' => $this->train_number,
            'line_number' => $this->line_number,
            'service_number' => $this->service_number,

            'current_state' => new SnapshotResource($this->snapshots()->orderByDesc("created_at")->first()),

            'from' => $this->from,
            'to' => $this->to,
            'operator' => $this->operator
        ];
    }
}
