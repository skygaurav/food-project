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
        $rules = [
            'name' => ['required', 'string', 'max:200'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'meal_cost' => ['nullable', 'numeric', 'min:0'],
            'good_date_spot' => ['nullable', 'boolean'],
            'website' => ['nullable', 'string', 'max:255', 'url'],
            'reservation' => ['nullable', 'boolean'],
            'phone' => ['nullable', 'string', 'max:50'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'max:5120'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'main_image_index' => ['nullable', 'integer', 'min:0'],
        ];

        // Either restaurant_id OR restaurant_name is required
        if ($this->filled('restaurant_id')) {
            $rules['restaurant_id'] = ['required', 'integer', 'exists:restaurants,id'];
        } else {
            $rules['restaurant_name'] = ['required', 'string', 'max:200'];
            $rules['restaurant_city'] = ['required', 'string', 'max:100'];
            $rules['restaurant_state'] = ['required', 'string', 'max:100'];
            $rules['restaurant_postcode'] = ['required', 'string', 'max:20'];
            $rules['restaurant_address'] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The dish name is required.',
            'images.required' => 'At least one photo is required.',
            'images.min' => 'At least one photo is required.',
            'images.*.image' => 'Each file must be an image.',
            'images.*.max' => 'Each image must be less than 5MB.',
            'restaurant_id.exists' => 'The selected restaurant does not exist.',
            'restaurant_name.required' => 'Please select or enter a restaurant name.',
            'restaurant_city.required' => 'City is required for new restaurants.',
            'restaurant_state.required' => 'State is required for new restaurants.',
            'restaurant_postcode.required' => 'Postcode is required for new restaurants.',
        ];
    }
}
