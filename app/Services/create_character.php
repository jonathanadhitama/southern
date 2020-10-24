<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
require_once 'utility.php';

/**
 * Function that checks the given data before inserting the character into DB
 * If any given attribute is invalid, it will not insert data into the DB
 * @return array
 * @param array $data
 */
function create_character(array $data)
{
    $success = true;
    $messages = [];
    //Ensure height value is numeric
    if (array_key_exists('height', $data) && !is_numeric($data['height'])) {
        $message = 'Invalid height attribute ' . $data['height'];
        Log::info($message);
        $success = false;
        $messages[] = $message;
    }
    //Ensure mass value is numeric
    if (array_key_exists('mass', $data) && !is_numeric($data['mass'])) {
        $message = 'Invalid mass attribute ' . $data['mass'];
        Log::info($message);
        $success = false;
        $messages[] = $message;
    }
    //Ensure birth_year is correct
    if (array_key_exists('birth_year', $data) && !check_birth_year($data['birth_year'])) {
        $message = 'Invalid birth_year attribute ' . $data['birth_year'];
        Log::info($message);
        $success = false;
        $messages[] = $message;
    }
    //Ensure homeworld name is correct
    if (array_key_exists('homeworld', $data)) {
        $homeworld = validateHomeworldOrSpecies(config('swapi.search_homeworld_api'), $data['homeworld']);
        if (is_null($homeworld)) {
            $message = 'Invalid homeworld name ' . $data['homeworld'];
            Log::info($message);
            $success = false;
            $messages[] = $message;
        } else {
            $data['homeworld'] = $homeworld;
        }
    }
    //Ensure species name is correct
    if (array_key_exists('species', $data)) {
        $species = validateHomeworldOrSpecies(config('swapi.search_species_api'), $data['species']);
        if (is_null($species)) {
            $message = 'Invalid value species name ' . $data['species'];
            Log::info($message);
            $success = false;
            $messages[] = $message;
        } else {
            $data['species'] = $species;
        }
    }
    if ($success) {
        $result = DB::table('swapi_characters')->insert($data);
        if ($result) {
            return ['success' => true, 'messages' => ['Successfully inserted character ' . $data['name'] . ' into DB.']];
        } else {
            return ['success' => false, 'messages' => ['Fail to insert character ' . $data['name'] . ' into DB.']];
        }
    }
    return ['success' => false, 'messages' => $messages];
}
