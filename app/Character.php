<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $table = 'swapi_characters';

    protected $fillable = [
        'name',
        'height',
        'mass',
        'hair_colour',
        'birth_year',
        'gender',
        'homeworld',
        'species'
    ];

    public $timestamps = false;
}
