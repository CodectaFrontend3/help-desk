<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequest extends FormRequest
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
            'nombre_cliente' => 'required|string|max:255',
            'ruc' => 'required|string|max:11',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|email|max:255',
        ];
    }
}
