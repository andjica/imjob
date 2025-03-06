<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();
        return $user?->contributor?->id;
    }

    public function rules(): array
    {
        return [
            'description' => 'required|string',
            'image' => 'nullable|mimes:jpg,jpeg,png,svg|max:4048'
        ];
    }
}