<?php

namespace App\Http\Resources\Api\Position;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'positions' => CollectionResource::collection($this->resource)->resolve(),
        ];
    }

}
