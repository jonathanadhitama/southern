<?php


namespace App\Services;
require_once 'characters_jedi.php';
require_once 'mammal_homeworlds.php';
require_once 'import_characters.php';
require_once 'update_characters.php';

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

    public function updateCharactersToDB()
    {
        return updateCharacters();
    }
}
