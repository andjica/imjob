<?php

namespace App\Http\Requests;

use App\Enums\JobType;
use App\Models\SubCategory;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    protected function prepareForValidation()
    {
        // Ako korisnik popuni `otherSub`, pronađi ID "Other" podkategorije i postavi `subCategoryId`
        if ($this->filled('custom_subcategory')) {
            $otherSubCategory = SubCategory::where('name', 'Other')->first();

            if ($otherSubCategory) {
                $this->merge([
                    'subCategoryId' => $otherSubCategory->id, 
                    'custom_subcategory' => $this->input('custom_subcategory'),
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'jobWorldType' => ['required', Rule::in([JobType::INTERNATIONAL, JobType::NATIONAL])],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'categoryId' => ['required', 'integer', 'exists:categories,id'],
            'subCategoryId' => ['nullable', 'integer', 'exists:sub_categories,id'],
            'custom_subcategory' => ['nullable', 'string', 'max:255'],
            'countryId' => ['required', 'integer', 'exists:countries,id'],
            'cityId' => ['required', 'integer', 'exists:cities,id'],
            'jobTypeId' => ['required', 'integer', 'exists:job_types,id'],
            'salaryMin' => ['required', 'integer', 'min:0'],
            'salaryMax' => ['required', 'integer', 'gte:salaryMin'],
            'experienceLevel' => ['required', 'string', 'in:Entry-Level,Mid-Level,Senior-Level,Managerial'],
            'requiredSkills' => ['required', 'string', 'max:255'],
            'moreSkill' => ['array'],
            'moreSkill.*' => ['nullable', 'string'],
            'moreSkills' => ['array'],
            'moreSkills.*' => ['nullable', 'string'],
            'min_age' => ['required', 'integer', 'min:18'],
            'max_age' => ['required', 'integer', 'gte:min_age'],
            'special_requirements' => ['nullable', 'string'],
            'validUntil' => ['required', 'date', 'after_or_equal:today'],
            'companyId' => ['required', 'integer', 'exists:companies,id'],
        ];
    }
}
