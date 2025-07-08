<?php

namespace App\Services\AI;

use App\Models\Country;
use App\Services\AI\OpenAiService;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class CountryNormalizerService
{
    protected OpenAiService $ai;

    public function __construct(OpenAiService $ai)
    {
        $this->ai = $ai;
    }

    /**
     * Primeni mapiranje zemlje na upit za posao
     *
     * @param Builder $query
     * @param string|null $countryName
     * @param string $userLang
     * @return void
     */
   public function apply(Builder $query, ?string $countryName, string $userLang): Builder
    {
        if (!$countryName) {
            return $query;
        }

        // 1. Prevod ako je na lokalnom jeziku
        $translated = $this->ai->translateValueToLocal($countryName, $userLang);

        // 2. Mapa vrednosti u ISO kod
        $iso = $this->ai->mapCountryToIso($translated);

        // 3. Pronađi državu i dodaj where uslov
        if ($iso) {
            $country = Country::where('iso_code', $iso)->first();
            if ($country) {
                $query->where('country_id', $country->id);
            }
        }

        Log::info('CountryNormalizerService: map result', [
            'input' => $countryName,
            'translated' => $translated,
            'iso' => $iso,
        ]);

        return $query;
    }
}
