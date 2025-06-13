<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MachineRequest extends FormRequest
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
            'id_clientG' => 'required|integer|exists:clients_g,id',
            'id_company' => 'required|integer|exists:companies,id',
            'id_personN' => 'required|integer|exists:natural_persons,id',
            'id_plan' => 'required|integer|exists:plans,id',
            'type' => 'required|string|max:100',
            'brand'=> 'required|string|max:100',
            'username' => 'required|string|max:50',
            'end_revision' => 'required|date',
            'revision_scheduled' => 'required|date'
        ];
    }
}
