<?php

namespace App\Services\AI;

use App\Models\Job;
use Illuminate\Support\Collection;
use App\Services\AI\OpenAiService;

class JobPresenterService
{
    protected OpenAiService $ai;

    public function __construct(OpenAiService $ai)
    {
        $this->ai = $ai;
    }

    /**
     * Formatiraj niz poslova za prikaz u AI četu
     *
     * @param Collection $jobs
     * @param string $userLang
     * @return array
     */
    public function formatJobListForChat(Collection $jobs, string $userLang): array
{
    $result = [];

    foreach ($jobs as $job) {
        $needsTranslation = $job->language_code !== $userLang;

        // Prevedi tekstove ako jezik nije isti
        $translatedTitle = $needsTranslation ? $this->ai->translateToLanguage($job->title, $userLang) : $job->title;
        $translatedDescription = $needsTranslation ? $this->ai->translateToLanguage(strip_tags($job->description), $userLang) : strip_tags($job->description);
        $translatedCategory = $needsTranslation ? $this->ai->translateToLanguage($job->category->name ?? '', $userLang) : ($job->category->name ?? '');
        $translatedSubCategory = $needsTranslation ? $this->ai->translateToLanguage($job->subCategory->name ?? '', $userLang) : ($job->subCategory->name ?? '');
        $translatedExperience = $needsTranslation ? $this->ai->translateToLanguage($job->experience_level ?? '', $userLang) : $job->experience_level ?? '';
        $translatedJobType = $needsTranslation ? $this->ai->translateToLanguage($job->jobType->name ?? '', $userLang) : ($job->jobType->name ?? '');

        $currencySymbol = $job->country->currency_symbol ?? '€';

        $salaryRange = $job->salary_min && $job->salary_max
            ? "{$job->salary_min} - {$job->salary_max} {$currencySymbol}"
            : ($job->salary_min
                ? "{$job->salary_min}+ {$currencySymbol}"
                : ($job->salary_max
                    ? "Up to {$job->salary_max} {$currencySymbol}"
                    : null));

        $result[] = [
            'id' => $job->id,
            'title' => $translatedTitle,
            'company' => $job->company->name ?? null,
            'city' => $job->city->name ?? 'Unknown',
            'country' => $job->country->name ?? 'Unknown',
            'category' => $translatedCategory,
            'sub_category' => $translatedSubCategory,
            'original_language' => $job->language_code,
            'description' => $translatedDescription,
            'salary_min' => $job->salary_min,
            'salary_max' => $job->salary_max,
            'currency' => $currencySymbol,
            'salary_range' => $salaryRange,
            'experience_level' => $translatedExperience,
            'job_type' => $translatedJobType,
            'link' => url("/job/{$job->id}"),
        ];
    }

    return $result;
}


}
