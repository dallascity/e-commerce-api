<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => 'sometimes|integer|min:0',
        ];
    }
    public function messages(): array
    {
        return [
            'quantity.required' => 'Miktar gereklidir.',
            'quantity.integer' => 'Miktar bir tam sayı olmalıdır.',
            'quantity.min' => 'Miktar pozitif bir sayı olmalıdır.',
        ];
    }
}
