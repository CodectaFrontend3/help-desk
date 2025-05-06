<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NaturalPersonRequest extends FormRequest
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
            'dni' => 'required|string|max:8',
            'name' => 'required|string|max:50',
            'phone' => 'required|string|max:9',
            'email' => 'required|string|max:50',
        ];
    }
}
