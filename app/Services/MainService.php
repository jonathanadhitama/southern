<?php


namespace App\Services;
require_once 'characters_jedi.php';
require_once 'mammal_homeworlds.php';

class MainService
{
    public function getAllCharacters()
    {
        return getAllReturnOfTheJediCharacters();
    }

    public function getAllMammals()
    {
        return getAllMammalHomeworlds();
    }
}
