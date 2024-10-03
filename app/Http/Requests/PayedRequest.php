<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayedRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'data' => 'required|array',
        ];
    }
}
