<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SoftwareRequest extends FormRequest
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
            'name' => 'required|string',
            'license' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'supplier' => 'required|string',
            'installation_date' => 'required|date',
            'expiration_date' => 'required|date'
        ];
    }
}
