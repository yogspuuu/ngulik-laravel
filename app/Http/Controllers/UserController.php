<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show(): JsonResponse
    {
        return $this->userResponseJson(auth()->getToken()->get());
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $user = $this->user->create($request->all());

        auth()->login($user);

        return $this->userResponseJson(auth()->refresh());
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        auth()->user()->update($request->validated()['user']);

        return $this->userResponseJson(auth()->getToken()->get());
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if ($token = auth()->attempt($request->validated()['user'])) {
            return $this->userResponseJson($token);
        }

        abort(Response::HTTP_FORBIDDEN);
    }
}
