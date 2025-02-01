<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FollowContributorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool)auth()->user();
    }

    public function rules(): array
    {
        return [
            'follow_id' => 'required|integer',
        ];
    }
}
