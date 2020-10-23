<?php

namespace Tests\Feature;

use App\Services\MainService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use UpdatedCharactersSeeder;

class ImportCharactersTest extends TestCase
{
    use RefreshDatabase;

    private const C3PO_DATA = [
        "name" => "C-3PO",
        "height" => "167",
        "mass" => "75",
        "hair_color" => "n/a",
        "skin_color" => "gold",
        "eye_color" => "yellow",
        "birth_year" => "112BBY",
        "gender" => "n/a",
        "homeworld" => "http://swapi.dev/api/planets/1/",
        "species" => [
            "http://swapi.dev/api/species/2/"
        ],
    ];

    private const LUKE_SKYWALKER_DATA = [
        "name" => "Luke Skywalker",
        "height" => "172",
        "mass" => "77",
        "hair_color" => "blond",
        "skin_color" => "fair",
        "eye_color" => "blue",
        "birth_year" => "19BBY",
        "gender" => "male",
        "homeworld" => "http://swapi.dev/api/planets/1/",
        "species" => [],
    ];

    private const TATOOINE_DATA = [
        "name" => "Tatooine",
        "rotation_period" => "23",
        "orbital_period" => "304",
        "diameter" => "10465",
        "climate" => "arid",
        "gravity" => "1 standard",
        "terrain" => "desert",
        "surface_water" => "1",
        "population" => "200000",
    ];

    private const DROID_DATA = [
        "name" => "Droid",
        "classification" => "artificial",
        "designation" => "sentient",
        "average_height" => "n/a",
        "skin_colors" => "n/a",
        "hair_colors" => "n/a",
        "eye_colors" => "n/a",
        "average_lifespan" => "indefinite",
        "homeworld" => null,
        "language" => "n/a",
    ];

    private $emptyResultsCharacter = [
        "count" => 0,
        "next" => null,
        "previous" => null,
        "results" => []
    ];

    private $singleResultCharacter = [
        "count" => 1,
        "next" => null,
        "previous" => null,
        "results" => [
            self::C3PO_DATA
        ]
    ];

    private $resultCharacterWithNext = [
        "count" => 2,
        "next" => "http://swapi.dev/api/people/?page=2",
        "previous" => null,
        "results" => [
            self::C3PO_DATA
        ]
    ];

    private $resultNextCharacter = [
        "count" => 2,
        "next" => null,
        "previous" => "http://swapi.dev/api/people/?page=1",
        "results" => [
            self::LUKE_SKYWALKER_DATA
        ]
    ];

    /**
     * A basic insert character test with empty results
     *
     * @return void
     */
    public function testReceiveEmptyResults(): void
    {
        Http::fake([
            config('swapi.all_people_api') => Http::response($this->emptyResultsCharacter, 200)
        ]);

        $output = (new MainService())->importCharactersToDB();
        $this->assertDatabaseCount('swapi_characters', 0);

        $this->assertEquals(false, $output['success']);
        $this->assertEquals('No characters were inserted into the DB', $output['messages'][0]);
    }

    /**
     * A basic insert character test with single result
     *
     * @return void
     */
    public function testReceiveSingleResult(): void
    {
        Http::fake([
            config('swapi.all_people_api') => Http::response($this->singleResultCharacter, 200),
            'http://swapi.dev/api/planets/1/' => Http::response(self::TATOOINE_DATA, 200),
            'http://swapi.dev/api/species/2/' => Http::response(self::DROID_DATA, 200)
        ]);

        $output = (new MainService())->importCharactersToDB();
        $this->assertDatabaseCount('swapi_characters', 1);

        $this->assertEquals(true, $output['success']);
        $this->assertEquals('Inserted 1 characters into DB', $output['messages'][0]);
    }

    /**
     * A basic insert character test with next pagination
     *
     * @return void
     */
    public function testReceiveResultWithNext(): void
    {
        Http::fake([
            config('swapi.all_people_api') => Http::response($this->resultCharacterWithNext, 200),
            'http://swapi.dev/api/people/?page=2' => Http::response($this->resultNextCharacter, 200),
            'http://swapi.dev/api/planets/1/' => Http::response(self::TATOOINE_DATA, 200),
            'http://swapi.dev/api/species/2/' => Http::response(self::DROID_DATA, 200)
        ]);

        $output = (new MainService())->importCharactersToDB();
        $this->assertDatabaseCount('swapi_characters', 2);

        $this->assertEquals(true, $output['success']);
        $this->assertEquals('Inserted 2 characters into DB', $output['messages'][0]);
    }

    protected function tearDown(): void
    {
        //Run seeder to populate updated_characters_data table
        (new UpdatedCharactersSeeder())->run();
    }
}
