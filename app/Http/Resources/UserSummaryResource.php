<?php

namespace App\Http\Resources;

use App\Http\Resources\Team\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'is_staff' => $this->is_staff,
            'profile' => [
                'name' => $this->name,
            ],
        ];
    }
}
