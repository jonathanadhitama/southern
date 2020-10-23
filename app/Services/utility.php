<?php

use Illuminate\Support\Facades\Log;

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
