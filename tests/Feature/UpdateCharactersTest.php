<?php

namespace Tests\Feature;

use App\Character;
use App\Services\MainService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use UpdatedCharactersSeeder;

class UpdateCharactersTest extends TestCase
{
    use RefreshDatabase;

    private const NAME = 'Lorem Ipsum';
    private const ORIGINAL_HEIGHT = '150';
    private const ORIGINAL_MASS = '70';
    private const ORIGINAL_HAIR_COLOUR = 'n/a';
    private const ORIGINAL_BIRTH_YEAR = '12ABY';
    private const ORIGINAL_GENDER = 'male';
    private const ORIGINAL_HOMEWORLD = 'Naboo';
    private const ORIGINAL_SPECIES = 'Human';

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

    private const INVALID_UPDATE_DATA = [
        'name' => self::NAME,
        'height' => self::INVALID_HEIGHT,
        'mass' => self::INVALID_MASS,
        'hair_color' => self::ORIGINAL_HAIR_COLOUR,
        'birth_year' => self::INVALID_BIRTH_YEAR,
        'gender' => self::ORIGINAL_GENDER,
        'homeworld_name' => self::INVALID_HOMEWORLD,
        'species_name' => self::INVALID_SPECIES
    ];

    private const VALID_UPDATE_DATA = [
        'name' => self::NAME,
        'height' => self::VALID_HEIGHT,
        'mass' => self::VALID_MASS,
        'hair_color' => self::ORIGINAL_HAIR_COLOUR,
        'birth_year' => self::VALID_BIRTH_YEAR,
        'gender' => self::ORIGINAL_GENDER,
        'homeworld_name' => self::VALID_HOMEWORLD,
        'species_name' => self::VALID_SPECIES
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
        DB::table('swapi_characters')->insert(
            [
                'name' => self::NAME,
                'height' => self::ORIGINAL_HEIGHT,
                'mass' => self::ORIGINAL_MASS,
                'hair_colour' => self::ORIGINAL_HAIR_COLOUR,
                'birth_year' => self::ORIGINAL_BIRTH_YEAR,
                'gender' => self::ORIGINAL_GENDER,
                'homeworld' => self::ORIGINAL_HOMEWORLD,
                'species' => self::ORIGINAL_SPECIES
            ]
        );
        DB::table('updated_character_data')->truncate();

        Http::fake([
            config('swapi.search_homeworld_api') . self::VALID_HOMEWORLD => Http::response(self::VALID_SEARCH_HOMEWORLD_RESULT, 200),
            config('swapi.search_homeworld_api') . self::INVALID_HOMEWORLD => Http::response(self::INVALID_SEARCH_RESULT, 200),
            config('swapi.search_species_api') . self::VALID_SPECIES => Http::response(self::VALID_SEARCH_SPECIES_RESULT, 200),
            config('swapi.search_species_api') . self::INVALID_SPECIES => Http::response(self::INVALID_SEARCH_RESULT, 200),
        ]);
    }

    /**
     * Attempt to update an entry with invalid data
     *
     * @return void
     */
    public function testInvalidUpdateData()
    {
        DB::table('updated_character_data')->insert(self::INVALID_UPDATE_DATA);
        $output = (new MainService())->updateCharactersToDB();
        $this->assertTrue($output['success']);

        $character = Character::where('name', self::NAME)->first();
        $this->assertEquals(self::ORIGINAL_HEIGHT, $character->height);
        $this->assertEquals(self::ORIGINAL_MASS, $character->mass);
        $this->assertEquals(self::ORIGINAL_HAIR_COLOUR, $character->hair_colour);
        $this->assertEquals(self::ORIGINAL_BIRTH_YEAR, $character->birth_year);
        $this->assertEquals(self::ORIGINAL_GENDER, $character->gender);
        $this->assertEquals(self::ORIGINAL_HOMEWORLD, $character->homeworld);
        $this->assertEquals(self::ORIGINAL_SPECIES, $character->species);
    }

    /**
     * Attempt to update an entry with valid data
     *
     * @return void
     */
    public function testValidUpdateData()
    {
        DB::table('updated_character_data')->insert(self::VALID_UPDATE_DATA);
        $output = (new MainService())->updateCharactersToDB();
        $this->assertTrue($output['success']);

        $character = Character::where('name', self::NAME)->first();
        $this->assertEquals(self::VALID_HEIGHT, $character->height);
        $this->assertEquals(self::VALID_MASS, $character->mass);
        $this->assertEquals(self::ORIGINAL_HAIR_COLOUR, $character->hair_colour);
        $this->assertEquals(self::VALID_BIRTH_YEAR, $character->birth_year);
        $this->assertEquals(self::ORIGINAL_GENDER, $character->gender);
        $this->assertEquals(self::VALID_HOMEWORLD, $character->homeworld);
        $this->assertEquals(self::VALID_SPECIES, $character->species);
    }

    protected function tearDown(): void
    {
        DB::table('swapi_characters')->where('name',  '=',self::NAME)->delete();
        //Run seeder to populate updated_characters_data table
        (new UpdatedCharactersSeeder())->run();
    }
}
