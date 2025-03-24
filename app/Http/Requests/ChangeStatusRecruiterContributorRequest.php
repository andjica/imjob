<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusRecruiterContributorRequest extends FormRequest
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
            //'contributor_id' => 'required|integer|exists:contributors,id',
            'recruiter_id' => 'required|integer|exists:recruiters,id',
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            //'contributor_id.required' => 'Contrbitur ID is required.',
            //'contributor_id.exists' => 'The selected contributor does not exist.',
            'recruiter_id.required' => 'Recruiter ID is required.',
            'recruiter_id.exists' => 'The selected recruiter does not exist.',
        ];
    }
}
