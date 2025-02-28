<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:100|unique:zones,name,',
        ];
    }

    // ! not used
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la zona es obligatorio.',
            'name.unique' => 'El nombre de la zona ya esta en uso. Por Favor, elija otro',
            'name.max' => 'El nombre de la Zona no puede exceder los 100 caracteres.',
        ];
    }
}
