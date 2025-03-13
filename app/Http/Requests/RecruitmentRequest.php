<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Candidate;
use Illuminate\Validation\Rule;

class RecruitmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust if authorization logic is needed
    }

    public function rules(): array
    {
        return [
            'candidateId' => [
                'required',
                'integer',
                'exists:candidates,id',
                function ($attribute, $value, $fail) {
                    $candidate = Candidate::find($value);
                    if (!$candidate) {
                        $fail('The selected candidate does not exist.');
                    } elseif (!$candidate->job) {
                        $fail('The candidate is not associated with any job.');
                    }
                },
            ],
            'jobId' => [
                'required',
                'integer',
                'exists:jobs,id',
            ],
            'decision' => [
                'required',
                Rule::in(['hire', 'refuse']),
            ],
        ];
    }
}
