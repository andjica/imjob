<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Candidate;
use App\Models\RecruitmentProcess;
use Illuminate\Validation\Rule;

class RecruitmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust authorization logic if needed
    }

    public function rules(): array
    {
        return [
            'recruitment_process_id' => [
                'required',
                'integer',
                'exists:recruitment_processes,id',
            ],
            // 'candidateId' => [
            //     'required',
            //     'integer',
            // ],
            'decision' => [
                'required',
                Rule::in(['hire', 'refuse']),
            ],
        ];
    }

    /**
     * Custom validation: Ensure recruitment process exists for given candidate.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $recruitmentProcess = RecruitmentProcess::where('id', $this->recruitment_process_id)
                // ->where('candidate_id', $this->candidateId)
                ->first();

            if (!$recruitmentProcess) {
                $validator->errors()->add('recruitment_process_id', 'Invalid recruitment process for the given candidate.');
            }
        });
    }
}
