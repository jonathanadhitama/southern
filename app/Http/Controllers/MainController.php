<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MainService;


class MainController extends Controller
{
    public function handleCharactersROTJ()
    {
        $characters = (new MainService())->getAllCharacters();
        return view('characters_jedi', ['characters' => $characters]);
    }

    public function handleMammalHomeworlds()
    {
        $species = (new MainService())->getAllMammals();
        return view('mammal_homeworlds', ['species' => $species]);
    }

    public function importCharacterIntoDB()
    {
        $output = (new MainService())->importCharactersToDB();
        return view('import_characters', ['output' => $output]);
    }

    public function updateCharacterIntoDB()
    {
        $output = (new MainService())->updateCharactersToDB();
        return view('update_characters', ['output' => $output]);
    }

    public function createCharacter() {
        return view('create_character');
    }
}
