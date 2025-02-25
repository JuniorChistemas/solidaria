<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cambiar según las políticas de autorización
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
{
    $categoryId = $this->route('category') ? $this->route('category')->id : null;

    return [
        'name' => [
            'required',
            'string',
            'max:255',
            "unique:categories,name,{$categoryId}",
        ],
    ];
}

/**
 * Mensajes de error personalizados.
 */
public function messages(): array
{
    return [
        'name.required' => 'El nombre de la categoría es obligatorio.',
        'name.unique' => 'El nombre de la categoría ya está en uso. Por favor, elige otro.',
        'name.max' => 'El nombre de la categoría no puede superar los 255 caracteres.',
    ];
}


    
}
