<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "email" => $this->email,
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
            'bearer' => $this->token
        ];
    }
}
