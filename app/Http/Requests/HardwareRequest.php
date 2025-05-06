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
            'id_RH' => 'required|integer|exists:register_hardwares,id',
            'type_team' => 'required|string|max:50',
            'serial_number' => 'required|integer',
            'buy_date' => 'required|date',
            'plan' => 'string|max:50',
            'brand' => 'required|string|max:50',
            'supplier' => 'required|string|max:50',
            'description' => 'string|max:2000',
            'end_revision' => 'string|max:50',
            'revision_scheduled' => 'required|string|max:50',
        ];
    }
}
