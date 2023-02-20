<?php

namespace App\Htpp\Resource\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = 'user';

    public function toArray($request)
    {
        return [

        ];
    }
}