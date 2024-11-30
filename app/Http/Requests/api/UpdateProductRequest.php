<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'sometimes|string|max:100',
            'price' => 'sometimes|numeric|min:0|max:1000000',
            'stock' => 'sometimes|integer|min:0|max:10000',
            'description' => 'sometimes|string|max:500',
            'image' => 'sometimes|file|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'name.string' => 'Ürün adı sadece metin içermelidir.',
            'name.max' => 'Ürün adı en fazla 100 karakter olmalıdır.',

            'price.numeric' => 'Fiyat sadece sayısal bir değer olmalıdır.',
            'price.min' => 'Fiyat sıfırdan küçük olamaz.',
            'price.max' => 'Fiyat 1.000.000 TL’den büyük olamaz.',

            'stock.integer' => 'Stok miktarı tam sayı olmalıdır.',
            'stock.min' => 'Stok miktarı negatif olamaz.',
            'stock.max' => 'Stok miktarı 10.000 adedi geçemez.',

            'description.string' => 'Ürün açıklaması sadece metin içermelidir.',
            'description.max' => 'Ürün açıklaması en fazla 500 karakter olmalıdır.',

            'image.file' => 'Ürün görseli bir dosya olmalıdır.',
            'image.mimes' => 'Ürün görseli yalnızca jpg, jpeg, png veya gif formatında olabilir.',
            'image.max' => 'Ürün görseli en fazla 2 MB boyutunda olabilir.',
        ];
    }
}
