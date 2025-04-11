<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteGRequest extends FormRequest
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
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'direccion' => 'required|string|max:200',
            'correo' => 'required|email|max:50',
            'num_telefono' => 'required|string|max:9',
            'numero_plan' => 'required|integer'
        ];
    }
}
