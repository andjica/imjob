<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // If you have auth rules, modify this accordingly
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required|integer|exists:companies,id',
            'recruiter_id' => 'required|integer|exists:recruiters,id',
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'company_id.required' => 'Company ID is required.',
            'company_id.exists' => 'The selected company does not exist.',
            'recruiter_id.required' => 'Recruiter ID is required.',
            'recruiter_id.exists' => 'The selected recruiter does not exist.',
        ];
    }
}
