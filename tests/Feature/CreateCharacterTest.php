<?php

namespace Tests\Feature;

use App\Character;
use App\Services\MainService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CreateCharacterTest extends TestCase
{

    private const NAME = 'Lorem Ipsum';
    private const HAIR_COLOUR = 'n/a';
    private const GENDER = 'male';

    private const VALID_SPECIES = 'Wookie';
    private const VALID_BIRTH_YEAR = '13BBY';
    private const VALID_HOMEWORLD = 'Coruscant';
    private const VALID_HEIGHT = '175';
    private const VALID_MASS = '75';

    private const INVALID_SPECIES = 'IPSUM';
    private const INVALID_BIRTH_YEAR = 'LOREM IPSUM';
    private const INVALID_HOMEWORLD = 'IPSUM';
    private const INVALID_HEIGHT = 'TEST';
    private const INVALID_MASS = 'MASS';

    private const INVALID_INSERT_DATA = [
        'name' => self::NAME,
        'height' => self::INVALID_HEIGHT,
        'mass' => self::INVALID_MASS,
        'hair_colour' => self::HAIR_COLOUR,
        'birth_year' => self::INVALID_BIRTH_YEAR,
        'gender' => self::GENDER,
        'homeworld' => self::INVALID_HOMEWORLD,
        'species' => self::INVALID_SPECIES
    ];

    private const VALID_INSERT_DATA = [
        'name' => self::NAME,
        'height' => self::VALID_HEIGHT,
        'mass' => self::VALID_MASS,
        'hair_colour' => self::HAIR_COLOUR,
        'birth_year' => self::VALID_BIRTH_YEAR,
        'gender' => self::GENDER,
        'homeworld' => self::VALID_HOMEWORLD,
        'species' => self::VALID_SPECIES
    ];

    private const INVALID_SEARCH_RESULT = [
        "count" => 0,
        "next" => null,
        "previous" => null,
        "results" => []
    ];

    private const VALID_SEARCH_SPECIES_RESULT = [
        "count" => 1,
        "next" => null,
        "previous" => null,
        "results" => [
            [
                "name" => self::VALID_SPECIES,
                "classification" => "mammal",
                "designation" => "sentient",
                "average_height" => "180"
            ]
        ]
    ];

    private const VALID_SEARCH_HOMEWORLD_RESULT = [
        "count" => 1,
        "next" => null,
        "previous" => null,
        "results" => [
            [
                "name" => "Coruscant",
                "rotation_period" => "24",
                "orbital_period" => "368",
                "diameter" => "12240",
            ]
        ]
    ];

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake([
            config('swapi.search_homeworld_api') . self::VALID_HOMEWORLD => Http::response(self::VALID_SEARCH_HOMEWORLD_RESULT, 200),
            config('swapi.search_homeworld_api') . self::INVALID_HOMEWORLD => Http::response(self::INVALID_SEARCH_RESULT, 200),
            config('swapi.search_species_api') . self::VALID_SPECIES => Http::response(self::VALID_SEARCH_SPECIES_RESULT, 200),
            config('swapi.search_species_api') . self::INVALID_SPECIES => Http::response(self::INVALID_SEARCH_RESULT, 200),
        ]);
    }

    /**
     * Test to attempt to insert invalid data
     *
     * @return void
     */
    public function testInsertInvalidData()
    {
        $output = (new MainService())->insertCharacterToDB(self::INVALID_INSERT_DATA);
        $this->assertFalse($output['success']);
        $this->assertCount(5, $output['messages']);

        $character = Character::where('name', self::NAME)->first();
        $this->assertNull($character);
    }

    public function testInsertValidData() {
        $output = (new MainService())->insertCharacterToDB(self::VALID_INSERT_DATA);
        $this->assertTrue($output['success']);
        $this->assertCount(1, $output['messages']);

        $character = Character::where('name', self::NAME)->first();
        $this->assertNotNull($character);
        $this->assertEquals(floatval(self::VALID_HEIGHT), $character->height);
        $this->assertEquals(floatval(self::VALID_MASS), $character->mass);
        $this->assertEquals(self::HAIR_COLOUR, $character->hair_colour);
        $this->assertEquals(self::VALID_BIRTH_YEAR, $character->birth_year);
        $this->assertEquals(self::GENDER, $character->gender);
        $this->assertEquals(self::VALID_HOMEWORLD, $character->homeworld);
        $this->assertEquals(self::VALID_SPECIES, $character->species);
        $character->delete();
    }
}
