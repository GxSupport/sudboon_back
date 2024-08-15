<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'phone' => 'required',
            'password' => 'required',
            'remember_me' => 'required|boolean',
        ];
    }
    public function bodyParameters(): array
    {
        return [
            'phone' => [
                'description' => 'Номер телефона',
                'example' => '998901234567',
            ],
            'password' => [
                'description' => 'Пароль',
                'example' => 'password',
            ],
            'remember_me' => [
                'description' => 'Запомнить пользователя',
                'example' => 'true',
            ],
        ];
    }

}
