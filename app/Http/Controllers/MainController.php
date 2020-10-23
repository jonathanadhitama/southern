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
}
