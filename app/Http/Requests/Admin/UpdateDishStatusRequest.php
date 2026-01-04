<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form request for updating a dish's status.
 *
 * Validates status value (pending, approved, or rejected).
 *
 * @package App\Http\Requests\Admin
 */
class UpdateDishStatusRequest extends FormRequest
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
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
        ];
    }
}
