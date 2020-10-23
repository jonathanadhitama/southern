<?php


namespace App\Services;
require_once 'characters_jedi.php';
require_once 'mammal_homeworlds.php';
require_once 'import_characters.php';

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

    public function importCharactersToDB()
    {
        return insertCharacterIntoDB();
    }
}
