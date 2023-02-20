<?php

namespace App\Htpp\Resource\User;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public static $wrap = '';

    public function toArray($request)
    {
        return ['user' => $this->collection];
    }
}