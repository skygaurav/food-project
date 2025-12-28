<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'region' => ['required', 'string', 'max:120'],
            'country' => ['required', 'string', 'max:120'],
            'postcode' => ['required', 'string', 'max:20'],
            'website' => ['nullable', 'url', 'max:255'],
            'opening_hours' => ['nullable', 'string'],
            'meal_cost' => ['nullable', 'numeric', 'min:0'],
            'good_date_spot' => ['nullable', 'boolean'],
            'phone' => ['nullable', 'string', 'max:50'],
            'reservation' => ['nullable', 'boolean'],
            'category_ids' => ['required', 'array'],
            'category_ids.*' => ['integer', 'exists:categories,id'],
        ];
    }
}
