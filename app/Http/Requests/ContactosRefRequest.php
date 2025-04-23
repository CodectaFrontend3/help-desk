<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactosRefRequest extends FormRequest
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
            'empresa_id' => 'required|exists:empresas,id',
            'microempresa_id' => 'required|exists:micro_empresas,id',
            'persona_natural_id' => 'required|exists:persona_naturals,id',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'required|string|max:15',
            'cargo' => 'required|string|max:100',
        ];
    }
}
