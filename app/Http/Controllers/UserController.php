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
    protected $message;

    public function __construct(User $user)
    {
        $message = config('constant.messages');

        $this->message = $message;
        $this->user = $user;
    }

    public function show(): JsonResponse
    {
        return $this->userResponse(jwtToken: auth()->getToken()->get());
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $user = $this->user->create($request->all());

        auth()->login($user);

        return $this->userResponse(jwtToken: auth()->refresh(), message: $this->message['user']['store']['success']);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        auth()->user()->update($request->all());

        return $this->userResponse(jwtToken: auth()->getToken()->get());
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if ($token = auth()->attempt($request->all())) {
            return $this->userResponse(jwtToken: $token, message: $this->message['user']['auth']['success']);
        }

        return $this->userResponse(message: $this->message['user']['auth']['failed'], status: false);
    }
}
