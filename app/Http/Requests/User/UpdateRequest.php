<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'sometimes|string|max:50|unique:users,username',
            'email' => 'sometimes|email|max:255|unique:users,email',
            'password' => 'sometimes',
            'image' => 'sometimes|url',
            'bio' => 'sometimes|string|max:2048'
        ];
    }
}
