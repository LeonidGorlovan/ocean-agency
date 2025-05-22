<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string email
 * @property string password
 * @property string device_name
 */
class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
