<?php

use App\Character;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

require_once 'utility.php';

function updateCharacters()
{
    $updatedData = DB::table('updated_character_data')->get();
    if (count($updatedData) === 0) {
        Log::info('Unable to find Updated Characters Data');
        return ['success' => false, 'messages' => ['No Updated Characters Data Present']];
    }
    $updateCount = 0;
    $notUpdated = [];
    Log::info('Found ' . count($updatedData) . ' records of  Updated Characters Data');
    foreach ($updatedData as $entry) {
        $output = sanitiseAndValidateData($entry);
        //First check whether character exists
        if (Character::where('name', $output['name'])->exists()) {
            Log::info('Updating character name ' . $output['name']);
            //If it exist, update the record
            Character::updateOrCreate(
                ['name' => $output['name']],
                $output
            );
            $updateCount += 1;
        } else {
            Log::info('Unable to update character name ' . $output['name'] . ' since record does not exist.');
            $notUpdated[] = $output['name'];
        }
    }
    if ($updateCount === 0) {
        Log::info('Unable to update any character data.');
        return ['success' => false, 'messages' => ['No Character Data updated.']];
    } else if ($updateCount < count($updatedData)) {
        Log::info('Unable to update a few characters data.');
        return ['success' => false, 'messages' => array_map(function ($name) {
            return 'Unable to update character name ' . $name . ' since record does not exist.';
        }, $notUpdated)];
    } else {
        Log::info('Update all characters data.');
        return ['success' => true, 'messages' => ['All Character data updated.']];
    }

}

function sanitiseAndValidateData($entry)
{
    $output = [
        'name' => $entry->name,
        'hair_colour' => $entry->hair_color,
        'gender' => $entry->gender
    ];
    if (is_numeric($entry->height)) {
        $output['height'] = $entry->height;
    }
    if (is_numeric($entry->mass)){
        $output['mass'] = $entry->mass;
    }
    if (check_birth_year($entry->birth_year)) {
        $output['birth_year'] = $entry->birth_year;
    }
    if (is_string($entry->homeworld_name) && strlen($entry->homeworld_name) > 0) {
        $homeworld = validateHomeworldOrSpecies(config('swapi.search_homeworld_api'), $entry->homeworld_name);
        if (!is_null($homeworld)) {
            $output['homeworld'] = $homeworld;
        }
    }
    if (is_string($entry->species_name) && strlen($entry->species_name) > 0) {
        $species = validateHomeworldOrSpecies(config('swapi.search_species_api'), $entry->species_name);
        if (!is_null($species)) {
            $output['species'] = $species;
        }
    }
    return $output;
}


