<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Function that gets the next Pagination URL
 * @param mixed $responseData
 * @return string|null
 */
function getNextUrlPagination($responseData)
{
    if (is_array($responseData) && array_key_exists('next', $responseData)) {
        //Check for next pagination for entry
        if (!is_null($responseData['next'])) {
            Log::info('Next is ' . $responseData['next']);
        } else {
            Log::info('Next is NULL');
        }
        $next = $responseData['next'];
    } else {
        Log::info('Next is null');
        $next = null;
    }
    return $next;
}

/**
 * Function to check birth_year
 * Acceptable values include: unknown, 13BBY, 13 ABY
 * @param string $year
 * @return bool
 */
function check_birth_year(string $year)
{
    if (strtolower($year) === 'unknown') {
        return true;
    }
    $temp = strtoupper($year);
    //Remove BBY and ABY
    $justNumericValue = str_replace('BBY', '', $temp);
    $justNumericValue = str_replace('ABY', '', $justNumericValue);

    //So should only contain numeric value
    return is_numeric($justNumericValue);
}

/**
 * Function that calls SWAPI to validate homeworld name or species name
 * @param string $baseUrl
 * @param string $search
 * @return string|null
 */
function validateHomeworldOrSpecies(string $baseUrl, string $search) {
    $response = Http::get($baseUrl . $search);
    if (strpos($baseUrl, 'species') !== false) {
        //Currently validating species name
        $which = 'species';
    } else {
        $which = 'homeworld';
    }
    if ($response->successful()) {
        $data = $response->json();
        if (
            is_array($data) &&
            array_key_exists('results', $data) &&
            is_array($data['results']) &&
            count($data['results']) === 1
        ) {
            //Ensure that homeworld/species is correct when searching via API only returns one single result
            if (array_key_exists('name', $data['results'][0])) {
                Log::info('Valid ' . $which . ' ' . $data['results'][0]['name']);
                return $data['results'][0]['name'];
            }
        }
    }
    Log::info('Invalid ' . $which . ' ' . $search);
    return null;
}
