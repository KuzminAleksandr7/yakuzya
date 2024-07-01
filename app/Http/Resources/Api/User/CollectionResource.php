<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'                     => $this->id,
            'firstname'              => $this->firstname,
            'lastname'               => $this->lastname,
            'email'                  => $this->email,
            'phone'                  => $this->phone,
            'position'               => $this->position->name ?? null, // так як при видаленні посади position_id стає null, position = null
            'position_id'            => $this->position_id,
            'registration_timestamp' => $this->created_at->timestamp,
            'photo'                  => $this->photo,
        ];
    }
}
