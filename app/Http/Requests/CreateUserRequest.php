<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:150',
            'name' => 'required|max:150',
            'password' => 'required|min:5'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
