<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
require_once 'utility.php';

/**
 * Function that inserts Characters into DB
 * @return array
 */
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
            Log::info('Successful API Call of ' . $next);
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
                    $homeworld = null;
                    $species = null;

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
            Log::alert('Attempt to insert batch #' . strval($i) . ' into DB');
            $result = DB::table('swapi_characters')->insert($characterChunks[$i]);
            if (!$result) {
                $message = 'Error when attempting to insert character batch #' . strval($i) . ' into DB';
                Log::error($message);
                $errorMessages[] = $message;
            } else {
                $message = 'Successfully inserted character batch #' . strval($i) . ' into DB';
                Log::info($message);
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

/**
 * Function that retrieves species / homeworld name
 * @param string $url
 * @return string|null
 */
function getHomeworldOrSpeciesData(string $url)
{
    $response = Http::get($url);
    if ($response->successful()) {
        Log::info('Successful API Call of ' . $url);
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

/**
 * Function that formats and validates the given data before it is inserted in to the DB
 * @param array $character
 * @param string|null $homeworld
 * @param string|null $species
 * @return array
 */
function characterMapper(array $character, ?string $homeworld, ?string $species)
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
            //Checking birth_year
            if ($attribute === 'birth_year' && check_birth_year($character[$attribute])) {
                $output[$modelAttribute] = $character[$attribute];
            } else if ($attribute === 'birth_year') {
                //Invalid birth_year we save as null
                Log::info('Invalid value detected for ' . $attribute . ' with value of ' . $character[$attribute]);
                $output[$modelAttribute] = null;
            } else if ($attribute === 'height' || $attribute === 'mass') {
                //Checking value for height and mass attribute
                if (is_numeric($character[$attribute])) {
                    $output[$modelAttribute] = $character[$attribute];
                } else {
                    Log::info('Invalid value detected for ' . $attribute . ' with value of ' . $character[$attribute]);
                    $output[$modelAttribute] = null;
                }
            }else {
                //For other attributes we save as normal
                $output[$modelAttribute] = $character[$attribute];
            }
        }
    }
    return $output;
}
