<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HardwareRequest extends FormRequest
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
            'id_RH' => 'required|integer|exists:registro_hardware,id',
            'tipo_equipo' => 'required|string|max:50',
            'num_serie' => 'required|integer',
            'fecha_compra' => 'required|date',
            'plan' => 'string|max:50',
            'marca' => 'required|string|max:50',
            'proveedor' => 'required|string|max:50',
            'descripcion' => 'string|max:2000',
            'ult_revision' => 'string|max:50',
            'rev_programada' => 'required|string|max:50',
        ];
    }
}
