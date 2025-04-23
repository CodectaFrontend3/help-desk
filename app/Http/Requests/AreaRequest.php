<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
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
            'microempresa_id' => 'required|exists:microempresa,id',
            'empresa_id' => 'required|exists:empresa,id',
            'sucursal_id' => 'required|exists:sucursal,id',
            'nombre_area' => 'required|string|max:255',
            'contacto' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|email|max:255',
        ];
    }
}
