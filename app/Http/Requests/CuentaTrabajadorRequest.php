<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CuentaTrabajadorRequest extends FormRequest
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
            'id_equipos'      => 'required|exists:equipo,id',
            'nombre_usuario'  => 'required|string|max:50',
            'area'            => 'required|string|max:50',
            'correoT'         => 'required|email|max:50',
            'contraseña'      => 'required|string|max:50',
            'sucursal'        => 'required|string|max:100'
        ];
    }
}
