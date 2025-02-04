<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            //fali google link for google meet
            'candidate_id' => ['required', 'exists:candidates,id'],
            'meeting_title' => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'available_subphase_id' => ['required', 'exists:available_recruitment_subphases,id'],
            'scheduled_at' => ['required', 'date'],
            'contributors' => ['array'],
            'contributors.*' => ['integer'],
        ];
    }
}
