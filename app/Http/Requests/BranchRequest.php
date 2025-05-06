<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
            'company_id' => 'required|exists:companies,id',
            'branch_name' => 'required|string|max:200',
            'manager' => 'required|string|max:50',
            'phone' => 'required|string|max:9',
            'email' => 'required|string|max:255',
        ];

    }
}
