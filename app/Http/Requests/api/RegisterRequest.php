<?php

namespace App\Http\Requests\api;

class RegisterRequest extends ApiRequest
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
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:320|unique:users',
            'password' => 'required|string|min:8|max:16|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ad alanı zorunludur.',
            'name.max' => 'Ad en fazla 50 karakter olabilir.',

            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.max' => 'E-posta en fazla 320 karakter olabilir.',
            'email.unique' => 'Bu e-posta adresi zaten kayıtlıdır.',

            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 8 karakter olmalıdır.',
            'password.max' => 'Şifre en fazla 16 karakter olabilir.',
            'password.confirmed' => 'Şifre ve şifre tekrar alanı eşleşmiyor.',

            'role.required' => 'Rol alanı zorunludur.',
            'role.in' => 'Rol yalnızca admin veya user olabilir.',
        ];
    }
}
