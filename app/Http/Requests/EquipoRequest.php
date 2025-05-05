<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipoRequest extends FormRequest
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
            'id_clienteG' => 'required|integer|exists:cliente_g,id',
            'id_empresa' => 'required|integer|exists:empresa,id',
            'id_microempresa' => 'required|integer|exists:micro_empresas,id',
            'id_personaN' => 'required|integer|exists:persona_natural,id',
            'id_plan' => 'required|integer|exists:planes,id',
            'tipo' => 'required|string|max:100',
            'marca'=> 'required|string|max:100',
            'nombre_usuario' => 'required|string|max:50',
            'ult_revision' => 'required|date',
            'revision_programada' => 'required|date'
        ];
    }
}
