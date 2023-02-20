<?php

namespace App\Http\Resources\Profile;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResouce extends JsonResource
{
    public static $wrap = 'profile';

    public function toArray($request)
    {
        return [
            
        ];
    }
}