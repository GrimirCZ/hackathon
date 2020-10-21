<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConnectionResourceWithoutWaitFor extends JsonResource
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

            'current_state' => $this->when($this->snapshots()->orderByDesc("created_at")->count() > 0, new SnapshotResource($this->snapshots()->orderByDesc("created_at")->first())),

            'from' => $this->from,
            'to' => $this->to,
            'operator' => $this->operator
        ];
    }
}
