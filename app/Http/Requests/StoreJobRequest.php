<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        return [
            'title' => ['required', 'string', 'max:255'],
            'jobWorldType' => ['required'],
            'description' => ['required','string','max:65535'],
            'categoryId' => ['required', 'integer', 'exists:categories,id'],
            'subCategoryId' => ['required', 'integer', 'exists:sub_categories,id'],
            'countryId' => ['required', 'integer', 'exists:countries,id'],
            'cityId' => ['required', 'integer', 'exists:cities,id'],
            'jobTypeId' => ['required', 'integer', 'exists:job_types,id'],
            'salaryMin' => ['required', 'integer', 'min:0'],
            'salaryMax' => ['required', 'integer', 'gte:salaryMin'],
            'experienceLevel' => ['required', 'string', 'in:Entry-Level,Mid-Level,Senior-Level'],
            'requiredSkills' => ['required', 'string'],
            // 'requiredSkills.*' => ['string'],
            // 'moreSkill' => ['string'],
            // 'moreSkill' => ['nullable','array'],
            // 'moreSkill.*' => ['string'],
            'min_age' => ['required', 'integer', 'min:18'],
            'max_age' => ['required', 'integer', 'gte:min_age'],
            'special_requirements' => ['nullable', 'string'],
            'special_details' => ['nullable', 'string'],
            'validUntil' => ['required', 'date', 'after_or_equal:today'],
            'companyId' => ['required', 'integer', 'exists:companies,id'],
            /*'companyName' => ['nullable', 'string', 'max:500'],*/
        ];
    }
}
