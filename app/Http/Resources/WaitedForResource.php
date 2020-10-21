<?php

namespace App\Http\Resources;

use App\Models\Connection;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\WaitedForConnections */
class WaitedForResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'minutes' => $this->minutes,
            'station' => $this->station,
            'for' => new ConnectionResource($this->awaited_for()->first())
        ];
    }
}
