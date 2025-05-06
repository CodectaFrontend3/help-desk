<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
           'client_name' => 'required|string|max:50',
           'ruc' => 'required|string|max:11',
           'address' => 'required|string|max:200',
           'phone' => 'required|string|max:9',
           'email' => 'required|string|max:25',
        ];
    }
}
