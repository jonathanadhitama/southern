<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCharacterRequest;
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

    public function createCharacterSubmit(CreateCharacterRequest $request) {
        $output = (new MainService())->insertCharacterToDB($request->all());
        return response()->json($output);
    }
}
