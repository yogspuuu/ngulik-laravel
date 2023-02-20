<?php

namespace App\Http\Resources\Profile;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProfileCollection extends ResourceCollection
{
    public static $warp = '';

    public function toArray($request)
    {
        return ['profile' => $this->collection];
    }
}