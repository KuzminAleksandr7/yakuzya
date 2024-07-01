<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'id'          => $this->id,
                'firstname'   => $this->firstname,
                'lastname'    => $this->lastname,
                'email'       => $this->email,
                'phone'       => $this->phone,
                'position'    => $this->position->name ?? null, // так як при видаленні посади position_id стає null, position = null
                'position_id' => $this->position_id,
                'photo'       => $this->photo,
            ]
        ];
    }
}
