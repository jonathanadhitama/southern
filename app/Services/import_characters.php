<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
require_once 'utility.php';

function insertCharacterIntoDB() {
    $allCharacters = [];
    $cacheHomeworld = [];
    $cacheSpecies = [];
    $next = config('swapi.all_people_api');
    while (true) {
        if (is_null($next)) {
            Log::info('No more characters to retrieve, breaking off main loop.');
            break;
        }
        $response = Http::get($next);
        if ($response->successful()) {
            $characters = $response->json();
            //Get next URL for pagination
            $next = getNextUrlPagination($characters);
            if (is_array($characters) && array_key_exists('results', $characters)) {
                Log::info('Found ' . count($characters['results']) . ' new characters.');
                foreach ($characters['results'] as $character) {
                    if (!is_array($character)) {
                        //Invalid data so skip current loop
                        continue;
                    }
                    $homeworld = 'n/a';
                    $species = 'n/a';

                    //Handling homeworld
                    if (
                        array_key_exists('homeworld', $character) &&
                        !is_null($character['homeworld'])
                    ) {
                        //Check if we have called this homeworld api data before
                        //If we do, then load it from cache instead of doing another API call
                        //If we haven't, then call API and store in cache
                        if (!array_key_exists($character['homeworld'], $cacheHomeworld)) {
                            $temp = getHomeworldOrSpeciesData($character['homeworld']);
                            if (!is_null($temp)) {
                                Log::info('Caching ' . $character['homeworld'] . ' with value ' . $temp);
                                $homeworld = $temp;
                                $cacheHomeworld[$character['homeworld']] = $temp;
                            }
                        } else {
                            $temp = $cacheHomeworld[$character['homeworld']];
                            Log::info('Homeworld ' . $temp . ' exists in cache.');
                            $homeworld = $temp;
                        }
                    }

                    //Handling species
                    if (
                        array_key_exists('species', $character) &&
                        is_array($character['species']) &&
                        count($character['species']) > 0
                    ) {
                        //Check if we have called this species api data before
                        //If we do, then load it from cache instead of doing another API call
                        //If we haven't, then call API and store in cache
                        $speciesUrl = $character['species'][0];
                        if (!array_key_exists($speciesUrl, $cacheSpecies)) {
                            $temp = getHomeworldOrSpeciesData($speciesUrl);
                            if (!is_null($temp)) {
                                Log::info('Caching ' . $speciesUrl . ' with value ' . $temp);
                                $species = $temp;
                                $cacheSpecies[$speciesUrl] = $temp;
                            }
                        } else {
                            $temp = $cacheSpecies[$speciesUrl];
                            Log::info('Species ' . $temp . ' exists in cache.');
                            $species = $temp;
                        }
                    }
                    $temp = characterMapper($character, $homeworld, $species);
                    if (count($temp) > 0) {
                        Log::info('Inserting ' . $temp['name'] . ' for later DB Insertion');
                        $allCharacters[] = $temp;
                    }
                }
            }
        } else {
            Log::info('Unable to retrieve URL ' . $next);
            break;
        }
    }
    if (count($allCharacters) > 0) {
        //We have some characters to save to DB
        Log::info('Total characters to be inserted into Database: ' . count($allCharacters));
        DB::table ('swapi_characters')->truncate();
        $characterChunks = array_chunk($allCharacters, config('constant.batch_insert'));
        Log::info('Breaking characters into batches of ' . count($characterChunks));
        $errorMessages = [];
        for ($i = 0; $i < count($characterChunks); $i++) {
            try {
                Log::alert('Attempt to insert batch #' . strval($i) . ' into DB');
                DB::table('swapi_characters')->insert($characterChunks[$i]);
            } catch (\Exception $e) {
                $message = 'Error when attempting to insert character batch #' . strval($i) . ' into DB: ' . $e->getMessage();
                Log::error($message);
                $errorMessages[] = $message;
            }
        }
        $success = count($errorMessages) === 0;
        if ($success) {
            return ['success' => true, 'messages' => ['Inserted ' . count($allCharacters) . ' characters into DB']];
        } else {
            return ['success' => false, 'messages' => $errorMessages];
        }
    } else {
        //We have no characters to save in DB
        return ['success' => false, 'messages' => ['No characters were inserted into the DB']];
    }
}

function getHomeworldOrSpeciesData($url)
{
    $response = Http::get($url);
    if ($response->successful()) {
        $data = $response->json();
        if (is_array($data) && array_key_exists('name', $data)) {
            return $data['name'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function characterMapper($character, $homeworld, $species)
{
    if (!array_key_exists('name', $character)) {
        //Name is required
        return [];
    }
    $otherAttributesToSave = ['height', 'mass', 'hair_color', 'birth_year', 'gender'];
    $actualModelAttributes = ['height', 'mass', 'hair_colour', 'birth_year', 'gender'];
    $output = ['name' => $character['name'], 'homeworld' => $homeworld, 'species' => $species];

    //Map response data attribute with actual model attributes
    for ($i = 0; $i < count($otherAttributesToSave); $i++) {
        $attribute = $otherAttributesToSave[$i];
        $modelAttribute = $actualModelAttributes[$i];
        if (array_key_exists($attribute, $character)) {
            $output[$modelAttribute] = $character[$attribute];
        }
    }
    return $output;
}
