<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class FollowCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();
        return $user?->company?->id !== (int) $this->request->get('company_id');
    }

    public function rules(): array
    {
        return [
            'company_id' => 'required|integer|exists:companies,id',
        ];
    }
}
