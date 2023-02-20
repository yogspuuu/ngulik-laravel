<?php

namespace App\Http\Resources\Profile;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResouce extends JsonResource
{
    public static $wrap = 'profile';

    public function toArray($request)
    {
        return [
            'profile' => $this->user->only('username', 'bio', 'image'),
            'following' => $this->user->doesUserFollowAnotherUser(auth()->id(), $this->user->id)
        ];
    }
}