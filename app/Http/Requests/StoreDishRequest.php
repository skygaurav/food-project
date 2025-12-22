<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDishRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'restaurant_id' => ['required', 'integer', 'exists:restaurants,id'],
            'name' => ['required', 'string', 'max:200'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'max:5120'],
        ];
    }
}
