<?php

namespace App\Services\AI;

use App\Models\Job;
use App\Models\City;
use App\Models\User;
use App\Models\Country;
use App\Models\JobType;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class OpenAiService
{
    protected $apiUrl = 'https://api.openai.com/v1/chat/completions';

    public function chat(array $options)
    {
        $response = Http::withOptions([
            'timeout' => 10,
        ])
            ->withToken(config('services.openai.key'))
            ->post($this->apiUrl, [
                'model' => $options['model'] ?? 'gpt-4o',
                'messages' => $options['messages'],
                'temperature' => $options['temperature'] ?? 0.1,
            ]);


        return $response->json();
    }

    /**
     * Automatska detekcija jezika poruke
     */
    public function detectLanguage($message): array
    {
        $response = $this->chat([
            'messages' => [
                ['role' => 'system', 'content' => 'Detect the language of the following message. Just return the full language name in English (e.g. "Spanish", "Serbian", "German").'],
                ['role' => 'user', 'content' => $message],
            ]
        ]);

        $langName = trim($response['choices'][0]['message']['content'] ?? 'English');
        $langCode = $this->normalizeLanguageCode($langName);

        return [
            'name' => $langName,
            'code' => $langCode,
        ];
    }


    /**
     * Prevod poruke na zadati jezik (npr. English)
     */
    public function translateToBaseLanguage($message, $targetLang = 'English')
    {
        $response = $this->chat([
            'messages' => [
                ['role' => 'system', 'content' => "Translate the following message to {$targetLang}. If it's already in {$targetLang}, just return it."],
                ['role' => 'user', 'content' => $message],
            ]
        ]);

        return trim($response['choices'][0]['message']['content'] ?? $message);
    }

    public function translateToLanguage(string $text, string $targetLangCode): string
    {
        $langNames = [
            'rs' => 'Serbian',
            'en' => 'English',
            'de' => 'German',
            'fr' => 'French',
            'nl' => 'Dutch',
            'it' => 'Italian',
            'gr' => 'Greek',
            'tr' => 'Turkish',
            'es' => 'Spanish',
        ];

        $targetLang = $langNames[$targetLangCode] ?? 'English';

        $response = $this->chat([
            'messages' => [
                ['role' => 'system', 'content' => "Translate the following text to {$targetLang}. Respond only with the translation."],
                ['role' => 'user', 'content' => $text],
            ],
            'temperature' => 0.1,
            'model' => 'gpt-4o'
        ]);

        return trim($response['choices'][0]['message']['content'] ?? $text);
    }


    public function bulkTranslate(array $lines, string $targetLang): array
    {
        $textToTranslate = implode("\n###\n", $lines);

        $response = $this->chat([
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "Translate each segment separated by ### to {$targetLang}. Keep the order. Return only the translations, separated by ###.",
                ],
                [
                    'role' => 'user',
                    'content' => $textToTranslate,
                ]
            ],
            'temperature' => 0,
        ]);

        $raw = trim($response['choices'][0]['message']['content'] ?? '');
        return explode("###", $raw);
    }

    public function translateValueToLocal($value, $targetLang = 'Serbian')
    {
        if (!$value) return null;

        $response = $this->chat([
            'messages' => [
                ['role' => 'system', 'content' => "Translate the following word to {$targetLang}, keeping it as short as possible. Return only the translated value."],
                ['role' => 'user', 'content' => $value],
            ],
            'temperature' => 0.1,
            'model' => 'gpt-4o'
        ]);

        return trim($response['choices'][0]['message']['content'] ?? $value);
    }


    /**
     * Da li je pitanje vezano za poslove
     */
    public function askIntent($message)
    {
        $response = $this->chat([
            'messages' => [
                [
                    'role' => 'system',
                    'content' => <<<PROMPT
                You are an assistant on a job search platform.

                Your task is to determine if the user is talking about job-related topics.

                Return "YES" if the user's message is about:
                - searching for a job
                - jobs in a specific country or city
                - employment opportunities
                - asking about companies hiring
                - working in a specific field like IT, marketing, sales, or healthcare

                Otherwise, return "NO".

                Do not explain anything. Just respond with YES or NO.
                PROMPT
                ],
                ['role' => 'user', 'content' => $message],
            ],
            'temperature' => 0.1,
            'model' => 'gpt-4o', // koristi direktno GPT-4o ovde
        ]);

        $answer = strtoupper(trim($response['choices'][0]['message']['content'] ?? 'NO'));

        Log::info('Intent AI response:', [
            'input' => $message,
            'answer' => $answer,
            'raw' => $response
        ]);

        return $answer === 'YES';
    }
   
    public function extractSearchParams(string $message): array
{
    $response = $this->chat([
        'messages' => [
            [
                'role' => 'system',
                'content' => <<<PROMPT
You are a multilingual job search assistant.

Your job is to extract **structured filters** from user messages related to job search.

You MUST:
- Understand user intent even if message is vague or a question
- Detect language (e.g. Serbian, Spanish, Turkish, Arabic...) and translate job-related terms to English
- Normalize phrases like:
    - "puno radno vreme" → "Full-Time"
    - "ne puno radno vreme" / "part time" → "Part-Time"
    - "ugovor" / "freelance" → "Contract" or "Freelance"
    - "iskustvo: junior" / "bez iskustva" → "Entry-Level"
    - "menadžer" / "direktor" → "Managerial"
    - Convert salary ranges even when informal ("above 2k", "between 3000 and 5000", etc.)
    - Return null for any field not clearly mentioned

Respond with VALID JSON ONLY in this format (⚠️ NO MARKDOWN, no backticks!):
{
  "city": "CityName or null",
  "country": "CountryName or null",
  "category": "JobCategory or null",
  "subcategory": "JobSubcategory or null",
  "salary_min": number or null,
  "salary_max": number or null,
  "experience_level": "Entry-Level | Mid-Level | Senior-Level | Managerial or null",
  "job_type": "Full-Time | Part-Time | Contract | Internship | Temporary | Freelance | Remote | On-Site | Commission | Volunteer or null"
}

⚠️ Do NOT use triple backticks (```) or markdown. Respond ONLY with raw JSON text.
PROMPT
            ],
            ['role' => 'user', 'content' => $message]
        ],
        'temperature' => 0.1,
    ]);

    $raw = trim($response['choices'][0]['message']['content'] ?? '{}');

    // Strip ```json and ``` if present
    if (str_starts_with($raw, '```')) {
        $raw = preg_replace('/^```json|^```|```$/m', '', $raw);
        $raw = trim($raw);
    }

    try {
        $parsed = json_decode($raw, true);
        if (!is_array($parsed)) {
            throw new \Exception('JSON decode did not return an array');
        }

        Log::debug('Parsed search filters from AI', [
            'raw' => $raw,
            'parsed' => $parsed
        ]);

        return [
            'city' => $parsed['city'] ?? null,
            'country' => $parsed['country'] ?? null,
            'category' => $parsed['category'] ?? null,
            'subcategory' => $parsed['subcategory'] ?? null,
            'salary_min' => isset($parsed['salary_min']) ? (int) $parsed['salary_min'] : null,
            'salary_max' => isset($parsed['salary_max']) ? (int) $parsed['salary_max'] : null,
            'experience_level' => $parsed['experience_level'] ?? null,
            'job_type' => $parsed['job_type'] ?? null,
        ];
    } catch (\Exception $e) {
        Log::warning('AI failed to return valid JSON for extractSearchParams', [
            'raw_response' => $raw,
            'error' => $e->getMessage(),
            'json_error' => json_last_error_msg()
        ]);

        return [
            'city' => null,
            'country' => null,
            'category' => null,
            'subcategory' => null,
            'salary_min' => null,
            'salary_max' => null,
            'experience_level' => null,
            'job_type' => null,
        ];
    }
}




    public function mapCountryToIso($countryName)
    {
        $map = [
            'RS' => ['Serbia', 'Srbija'],
            'DE' => ['Germany', 'Njemačka', 'Deutschland'],
            'FR' => ['France', 'Francuska', 'France'],
            'TR' => ['Turkey', 'Turska', 'Türkiye'],
            'IT' => ['Italy', 'Italija', 'Italia'],
            'GR' => ['Greece', 'Grčka', 'Ελλάδα'],
            'NL' => ['Netherlands', 'Holandija', 'Nederland'],
            'US' => ['USA', 'United States', 'Sjedinjene Američke Države', 'America'],
        ];

        $countryName = strtolower(trim($countryName));
        foreach ($map as $iso => $aliases) {
            foreach ($aliases as $alias) {
                if (strtolower($alias) === $countryName) {
                    return $iso;
                }
            }
        }

        return null;
    }


    public function normalizeLanguageCode($langName)
    {
        $map = [
            'Serbian' => 'rs',  // <- promena: vrati "rs" jer tako pišeš u bazu
            'English' => 'en',
            'German' => 'de',
            'French' => 'fr',
            'Dutch' => 'nl',
            'Italian' => 'it',
            'Greek' => 'gr',
            'Turkish' => 'tr',
            'Spanish' => 'es',
        ];

        return $map[$langName] ?? 'en';
    }

    public function getJobSearchResults(array $params)
    {
        $query = Job::query();

        if (!empty($params['city'])) {
            $params['city'] = $this->translateToBaseLanguage($params['city'], 'English');
        }

        if (!empty($params['country'])) {
            $params['country'] = $this->translateToBaseLanguage($params['country'], 'English');
        }

        if (!empty($params['category'])) {
            $category = Category::where('name', 'ILIKE', $params['category'])->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if (!empty($params['city'])) {
            $city = City::where('name', 'ILIKE', $params['city'])->first();
            if ($city) {
                $query->where('city_id', $city->id);
            }
        }

        return $query->latest()->limit(10)->get();
    }

    public function mapJobTypeToId($jobTypeName)
    {
        if (!$jobTypeName) return null;

        return JobType::where('name', $jobTypeName)->value('id');
    }


    public function normalizeSalary(int $salaryInput, string $currencyInput, string $countryName): int
    {
        $country = Country::where('name', $countryName)->first();
        if (!$country) return $salaryInput; // fallback

        $countryCurrency = strtoupper($country->currency);
        $userCurrency = strtoupper($currencyInput);

        if ($countryCurrency === $userCurrency) {
            return $salaryInput;
        }

        // Primeri konverzije
        if ($userCurrency === 'EUR' && $countryCurrency === 'RSD') {
            return $salaryInput * 117;
        }

        if ($userCurrency === 'RSD' && $countryCurrency === 'EUR') {
            return (int) ($salaryInput / 117);
        }

        return $salaryInput;
    }

}
