<?php

namespace App\Http\Controllers;

use App\Htpp\Resource\User\UserResource;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show(): UserResource
    {
        return $this->userResponseJson(auth()->getToken()->get());
    }

    public function store(StoreRequest $request): UserResource
    {
        $user = $this->user->create($request->validated()['user']);

        auth()->login($user);

        return $this->userResponseJson(auth()->refresh());
    }

    public function update(UpdateRequest $request): UserResource
    {
        auth()->user()->update($request->validated()['user']);

        return $this->userResponseJson(auth()->getToken()->get());
    }

    public function login(LoginRequest $request): UserResource
    {
        if ($token = auth()->attempt($request->validated()['user'])) {
            return $this->userResponseJson($token);
        }

        abort(Response::HTTP_FORBIDDEN);
    }
}
