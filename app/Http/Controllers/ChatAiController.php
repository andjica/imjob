<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\City;
use App\Models\Country;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\AI\OpenAiService;
use App\Services\AI\JobPresenterService;
use App\Services\AI\CountryNormalizerService;

class ChatAiController extends Controller
{
    protected OpenAiService $ai;
    protected CountryNormalizerService $countryNormalizer;
    protected JobPresenterService $jobPresenter;

    public function __construct(OpenAiService $ai, CountryNormalizerService $countryNormalizer, JobPresenterService $jobPresenter)
    {
        $this->ai = $ai;
        $this->countryNormalizer = $countryNormalizer;
        $this->jobPresenter = $jobPresenter;
    }

    
    public function handle(Request $request)
    {
        $userMessage = $request->get('message');

        $detectedLang = $this->ai->detectLanguage($userMessage);
        $userLang = $detectedLang['code'];
        $langName = $detectedLang['name'];

        $translatedMessage = $this->ai->translateToBaseLanguage($userMessage, 'English');
        Log::info('Translated message for intent check: ' . $translatedMessage);

        if (!$this->ai->askIntent($translatedMessage)) {
            $fallbackMsg = $this->ai->translateToLanguage('I can currently help only with job-related requests.', $userLang);
            return response()->json(['message' => $fallbackMsg]);
        }

        $params = $this->ai->extractSearchParams($translatedMessage);
        Log::info('AI extracted params:', $params);

        foreach (['category', 'subcategory', 'experience_level', 'city', 'country', 'job_type'] as $field) {
            if (!empty($params[$field])) {
                $params[$field] = strtolower($this->ai->translateToBaseLanguage($params[$field], 'English'));
            }
        }

        $jobsQuery = Job::with(['company', 'city', 'country', 'category', 'subcategory', 'jobType']);

        $city = $params['city'] ?? null;
        $country = $params['country'] ?? null;
        $category = $params['category'] ?? null;
        $subcategory = $params['subcategory'] ?? null;

        if ($city) {
            $cityModel = City::whereRaw('LOWER(name) = ?', [$city])->first();
            if ($cityModel) {
                $jobsQuery->where('city_id', $cityModel->id);
            } else {
                Log::warning('City not found: ' . $city);
            }
        } elseif ($country) {
            $countryModel = Country::whereRaw('LOWER(name) = ?', [$country])->first();
            if ($countryModel && $countryModel->iso_code) {
                $jobsQuery->where('language_code', $countryModel->iso_code);
            } else {
                Log::warning('Country not found or missing ISO: ' . $country);
            }
        }

        $categoryModel = null;
        $subcategoryModel = null;

        if ($category) {
            $categoryModel = Category::whereRaw('LOWER(name) = ?', [$category])->first();
            if (!$categoryModel) {
                $subcategoryModel = SubCategory::with('category')->whereRaw('LOWER(name) = ?', [$category])->first();
                if ($subcategoryModel && $subcategoryModel->category) {
                    $categoryModel = $subcategoryModel->category;
                }
            }
        }

        if ($categoryModel) {
            $jobsQuery->where('category_id', $categoryModel->id);
        }

        if ($subcategoryModel) {
            $jobsQuery->where('sub_category_id', $subcategoryModel->id);
        }

        if ($subcategory) {
            $explicitSub = SubCategory::whereRaw('LOWER(name) = ?', [$subcategory])->first();
            if ($explicitSub) {
                $jobsQuery->where('sub_category_id', $explicitSub->id);
            }
        }
        

        if (!empty($params['salary_min'])) {
            $jobsQuery->where('salary_min', '>=', $params['salary_min']);
        }
        if (!empty($params['salary_max'])) {
            $jobsQuery->where('salary_max', '<=', $params['salary_max']);
        }

        if (!empty($params['experience_level'])) {
            $jobsQuery->whereRaw('LOWER(experience_level) = ?', [$params['experience_level']]);
        }

        if (!empty($params['job_type'])) {
            $jobTypeModel = \App\Models\JobType::whereRaw('LOWER(name) = ?', [$params['job_type']])->first();
            if ($jobTypeModel) {
                $jobsQuery->where('job_type_id', $jobTypeModel->id);
            } else {
                Log::warning('Unknown job_type: ' . $params['job_type']);
            }
        }

        $jobs = $jobsQuery->get();

        if ($jobs->isEmpty()) {
            $responseText = $this->ai->translateToLanguage('Unfortunately, there are no jobs matching your request at the moment.', $userLang);
            return response()->json([
                'message' => $responseText,
                'jobs' => [],
                'filters_used' => $params,
                'language_code' => $userLang
            ]);
        }

        $presentedJobs = $this->jobPresenter->formatJobListForChat($jobs, $userLang);
        $responseText = $this->ai->translateToLanguage('Here are some jobs I found for you 👇', $userLang);

        return response()->json([
            'message' => $responseText,
            'jobs' => $presentedJobs,
            'filters_used' => $params,
            'language_code' => $userLang
        ]);
    }

    public function getTranslatedJob(Request $request, $id)
{
    $job = Job::with([
        'company',
        'city',
        'country',
        'category',
        'subcategory',
        'jobType',
        'skills'
    ])->find($id);

    if (!$job) {
        return response()->json(['error' => 'Job not found'], 404);
    }

    $userLang = $request->query('lang');
    if (!$userLang) {
        return response()->json(['error' => 'Missing lang parameter'], 400);
    }

    $needsTranslation = $job->language_code !== $userLang;

    $ai = $this->ai; // koristi injected AI servis

    try {
        $translatedTitle = $needsTranslation ? $ai->translateToLanguage($job->title, $userLang) : $job->title;
        $translatedDescription = $needsTranslation ? $ai->translateToLanguage(strip_tags($job->description), $userLang) : $job->description;
        $translatedCategory = $needsTranslation ? $ai->translateToLanguage($job->category->name ?? '', $userLang) : ($job->category->name ?? '');
        $translatedSubcategory = $needsTranslation ? $ai->translateToLanguage($job->subcategory->name ?? '', $userLang) : ($job->subcategory->name ?? '');
        $translatedJobType = $needsTranslation ? $ai->translateToLanguage($job->jobType->name ?? '', $userLang) : ($job->jobType->name ?? '');
        $translatedExperienceLevel = $needsTranslation ? $ai->translateToLanguage($job->experience_level, $userLang) : $job->experience_level;

        $translatedSkills = $job->skills->map(function ($skill) use ($ai, $userLang, $needsTranslation) {
            return [
                'name' => $needsTranslation ? $ai->translateToLanguage($skill->skill, $userLang) : $skill->skill,
                'required' => $skill->is_required,
            ];
        })->toArray();

    } catch (\Exception $e) {
        Log::warning("Translation error for job ID {$job->id}: " . $e->getMessage());
        return response()->json(['error' => 'Translation failed'], 500);
    }

    return response()->json([
        'id' => $job->id,
        'title' => $translatedTitle,
        'company' => $job->company->name ?? null,
        'city' => $job->city->name ?? 'Unknown',
        'country' => $job->country->name ?? 'Unknown',
        'category' => $translatedCategory,
        'sub_category' => $translatedSubcategory,
        'job_type' => $translatedJobType,
        'experience_level' => $translatedExperienceLevel,
        'skills' => $translatedSkills,
        'salary_min' => $job->salary_min,
        'salary_max' => $job->salary_max,
        'valid_until' => $job->valid_until,
        'description' => $translatedDescription,
        'original_language' => $job->language_code,
        'link' => url("/job/{$job->id}"),
    ]);
}

}
