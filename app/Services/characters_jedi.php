<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Function that fetches the list of Return of The Jedi character names
 * @return array
 */
function getAllReturnOfTheJediCharacters()
{
    $response = Http::get(config('swapi.all_films_api'));
    if ($response->successful()) {
        Log::info('Successful API Call of SWAPI all films API');
        $allFilms = $response->json();
        if (is_array($allFilms) && array_key_exists('results', $allFilms)) {
            //Get Return of the Jedi entry
            $rotj = array_values(array_filter($allFilms['results'], function ($film) {
                return array_key_exists('title', $film) && strtolower($film['title']) === 'return of the jedi';
            }));

            if (is_array($rotj) && count($rotj) > 0 && array_key_exists('characters', $rotj[0])) {
                Log::info('Successfully filtered Return of Jedi from all films');
                $output = [];
                //Get all character names inside Return of the Jedi
                foreach ($rotj[0]['characters'] as $character) {
                    Log::info('Attempt to get character detail of ' . $character);
                    $responseCharacter = Http::get($character);
                    if ($responseCharacter->successful()) {
                        Log::info('Successful in getting character detail of ' . $character);
                        $characterDetail = $responseCharacter->json();
                        if (is_array($characterDetail) && array_key_exists('name', $characterDetail)) {
                            Log::info('Inserting into output array ' . $characterDetail['name']);
                            $output[] = $characterDetail['name'];
                        }
                    }
                }
                return $output;
            }
        }
    }
    return [];
}
