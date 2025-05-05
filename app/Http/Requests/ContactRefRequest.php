<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRefRequest extends FormRequest
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
            'company_id'=> 'required|exists:companies,id',
            'micro_company_id'=> 'required|exists:micro_companies,id',
            'natural_person_id'=> 'required|exists:natural_persons,id',
            'name'=> 'required|string|max:255',
            'address'=> 'required|string|max:255',
            'email'=> 'required|email|max:255',
            'phone'=> 'required|string|max:9',
            'manager'=> 'required|string|max:50',
        ];
    }
}
