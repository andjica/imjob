<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class OpenAiService
{
    public function askIntent($message)
    {
        $prompt = <<<EOD
            Pitanje: "$message"

            Da li je ovo pitanje vezano za traženje posla, kategoriju ili lokaciju?

            Odgovori samo:
            DA
            ILI
            NE
            EOD;

        $response = Http::withToken(config('services.openai.key'))->post(
            'https://api.openai.com/v1/chat/completions',
            [
                'model' => 'gpt-4o',
                'messages' => [
                    ['role' => 'system', 'content' => 'Ti si AI koji proverava da li je pitanje relevantno za pretragu poslova.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 5,
            ]
        );

        return trim(strtoupper($response['choices'][0]['message']['content'] ?? 'NE')) === 'DA';
    }

    public function extractSearchParams($message)
    {
        $prompt = <<<EOD
            Pitanje korisnika: "$message"

            Vrati JSON u formatu:
            {
            "category": "IT",
            "city": "Beograd",
            "country": "Srbija"
            }
            EOD;

        $response = Http::withToken(config('services.openai.key'))->post(
            'https://api.openai.com/v1/chat/completions',
            [
                'model' => 'gpt-4o',
                'messages' => [
                    ['role' => 'system', 'content' => 'Ti si parser koji iz korisničkog pitanja izvlači kategoriju, grad i državu.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 100,
            ]
        );

        $json = $response['choices'][0]['message']['content'] ?? '{}';

        return json_decode($json, true);
    }

    public function extractSearchParamsWithUser($message, User $user)
    {
      $prompt = <<<EOD
        Korisnik {$user->name} postavio je sledeće pitanje (može biti na bilo kom jeziku):

        "$message"

        Bez obzira na jezik pitanja, razumi kontekst i vrati JSON sa sledećim podacima:
        {
        "category": "...",
        "city": "...",
        "country": "..."
        }

        Ako ništa ne možeš prepoznati, ostavi prazna polja.
        EOD;
        ;

        $response = Http::withToken(config('services.openai.key'))->post(
            'https://api.openai.com/v1/chat/completions',
            [
                'model' => 'gpt-4o',
                'messages' => [
                    ['role' => 'system', 'content' => 'Ti si AI koji razume poruke korisnika i personalizuje ih.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 120,
            ]
        );

        $json = $response['choices'][0]['message']['content'] ?? '{}';

        return json_decode($json, true);
    }

}
