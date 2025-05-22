<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string content
 */
class CreateCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
