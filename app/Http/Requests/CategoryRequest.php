<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name,',
        ];
    }
    


    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.unique' => 'El nombre de la categoría ya está en uso. Por favor, elige otro.',
            'name.max' => 'El nombre de la categoría no puede superar los 255 caracteres.',
        ];
    }
}
