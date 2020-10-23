<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
require_once 'utility.php';

/**
 * Function that fetches the list of species that are classified as mammals as well as their homeworld
 * @return array
 */
function getAllMammalHomeworlds()
{
    $allMammalSpecies = [];
    $next = config('swapi.all_species_api');
    while (true) {
        if (is_null($next)) {
            Log::info('No more species to retrieve, breaking off main loop.');
            break;
        }
        $response = Http::get($next);
        if ($response->successful()) {
            $species = $response->json();
            //Get next URL for pagination
            $next = getNextUrlPagination($species);
            if (is_array($species) && array_key_exists('results', $species)) {
                //Filter all species that is mammal and append to $allMammalSpecies and map
                //data to only have species name and species homeworld only
                $filteredSpecies = array_map(function ($entry) {
                    $homeworld = 'N/A';
                    if (!is_null($entry['homeworld'])) {
                        $response = Http::get($entry['homeworld']);
                        if ($response->successful()) {
                            Log::info('Successful attempt to get planet detail of ' . $entry['homeworld']);
                            $data = $response->json();
                            if (array_key_exists('name', $data)) {
                                $homeworld = $data['name'];
                            }
                        } else {
                            Log::info('Unsuccessful attempt to get planet detail of ' . $entry['homeworld']);
                        }
                    }
                    return [
                        'name' => $entry['name'],
                        'homeworld' => $homeworld
                    ];
                },
                    array_values(array_filter($species['results'], function ($entry) {
                        return is_array($entry) &&
                            array_key_exists('name', $entry) &&
                            array_key_exists('name', $entry) &&
                            array_key_exists('homeworld', $entry) &&
                            array_key_exists('classification', $entry) &&
                            strtolower($entry['classification']) === 'mammal';
                    }))
                );
                $allMammalSpecies = array_merge($allMammalSpecies, $filteredSpecies);
                Log::info('Added ' . count($filteredSpecies) . ' species to main output array');
            }
        } else {
            Log::info('Unable to retrieve URL ' . $next);
            break;
        }
    }
    return $allMammalSpecies;
}
