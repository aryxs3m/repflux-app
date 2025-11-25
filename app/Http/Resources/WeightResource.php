<?php

namespace App\Http\Resources;

use App\Models\Weight;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Weight $resource
 */
class WeightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'created_at' => $this->resource->created_at,
            'measured_at' => $this->resource->measured_at,
            'weight' => $this->resource->weight,
        ];
    }
}
