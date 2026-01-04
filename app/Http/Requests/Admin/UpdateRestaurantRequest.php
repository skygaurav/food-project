<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form request for updating an existing restaurant.
 *
 * Validates restaurant details and category associations.
 *
 * @package App\Http\Requests\Admin
 */
class UpdateRestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
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
