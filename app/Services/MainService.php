<?php


namespace App\Services;
require_once 'characters_jedi.php';

class MainService
{
    public function getAllCharacters()
    {
        return getAllReturnOfTheJediCharacters();
    }
}
