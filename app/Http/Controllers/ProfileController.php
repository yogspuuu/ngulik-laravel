<?php

namespace App\Http\Controllers;

use App\Http\Resources\Profile\ProfileResouce;
use App\Models\User;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileController extends Controller
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show(User $user): ProfileResouce
    {
        return $this->profileResponseJson($user);
    }

    public function follow(User $user): ProfileResouce
    {
        auth()->user()->following()->attach($user->id);

        return $this->profileResponseJson($user);
    }

    public function unfollow(User $user): ProfileResouce
    {
        auth()->user()->following()->detach($user->id);

        return $this->profileResponseJson($user);
    }
}
