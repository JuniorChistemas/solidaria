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
        $categoryId = $this->route('category') ? $this->route('category')->id : 'NULL';

        return [
            'name' => "required|string|max:255|unique:categories,name,{$categoryId},id",
            'state' => 'required|string|in:Activo,Inactivo',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.unique' => 'El nombre de la categoría ya está en uso. Por favor, elige otro.',
            'name.max' => 'El nombre de la categoría no puede superar los 255 caracteres.',
            'state.required' => 'El estado de la categoría es obligatorio.',
            'state.in' => 'El estado de la categoría debe ser Activo o Inactivo.',
        ];
    }
}
