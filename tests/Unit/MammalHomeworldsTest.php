<?php

namespace Tests\Unit;

use App\Services\MainService;
use Illuminate\Support\Facades\Http;

class MammalHomeworldsTest extends \Tests\TestCase
{
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

    private const HUMAN_DATA = [
        "name" => "Human",
        "classification" => "mammal",
        "designation" => "sentient",
        "average_height" => "180",
        "skin_colors" => "caucasian, black, asian, hispanic",
        "hair_colors" => "blonde, brown, black, red",
        "eye_colors" => "brown, blue, green, hazel, grey, amber",
        "average_lifespan" => "120",
        "homeworld" => "http://swapi.dev/api/planets/9/",
        "language" => "Galactic Basic",
    ];

    private const MON_CALAMARI_DATA = [
        "name" => "Mon Calamari",
        "classification" => "amphibian",
        "designation" => "sentient",
        "average_height" => "160",
        "skin_colors" => "red, blue, brown, magenta",
        "hair_colors" => "none",
        "eye_colors" => "yellow",
        "average_lifespan" => "unknown",
        "homeworld" => "http://swapi.dev/api/planets/31/",
        "language" => "Mon Calamarian"
    ];

    private $resultNoMammal = [
        "count" => 1,
        "next" => null,
        "previous" => null,
        "results" => [
            self::DROID_DATA
        ]
    ];

    private $resultWithMammal = [
        "count" => 2,
        "next" => null,
        "previous" => null,
        "results" => [
            self::HUMAN_DATA,
            self::DROID_DATA
        ]
    ];

    private $coruscantData = [
        "name" => "Coruscant",
        "rotation_period" => "24",
        "orbital_period" => "368",
        "diameter" => "12240",
        "climate" => "temperate",
        "gravity" => "1 standard",
        "terrain" => "cityscape, mountains",
        "surface_water" => "unknown",
        "population" => "1000000000000",
    ];

    private $monCalaData = [
        "name" => "Mon Cala",
        "rotation_period" => "21",
        "orbital_period" => "398",
        "diameter" => "11030",
        "climate" => "temperate",
        "gravity" => "1",
        "terrain" => "oceans, reefs, islands",
        "surface_water" => "100",
        "population" => "27000000000",
    ];

    private $resultWithMammalAndNext = [
        "count" => 3,
        "next" => "http://swapi.dev/api/species/?page=2",
        "previous" => null,
        "results" => [
            self::HUMAN_DATA,
            self::DROID_DATA
        ]
    ];

    private $resultMammalNext = [
        "count" => 3,
        "next" => null,
        "previous" => "http://swapi.dev/api/species/?page=1",
        "results" => [
            self::MON_CALAMARI_DATA
        ]
    ];

    /**
     * Test No Mammal Species Available
     *
     * @return void
     */
    public function testWithNoValidMammal()
    {
        Http::fake([
            config('swapi.all_species_api') => Http::response($this->resultNoMammal, 200)
        ]);
        $this->assertCount(0, (new MainService())->getAllMammals());
    }

    /**
     * Test Mammal Species Available With No Next
     *
     * @return void
     */
    public function testWithValidMammalAndNoNext()
    {
        Http::fake([
            config('swapi.all_species_api') => Http::response($this->resultWithMammal, 200),
            'http://swapi.dev/api/planets/9/' => Http::response($this->coruscantData, 200)
        ]);
        $output = (new MainService())->getAllMammals();
        $this->assertCount(1, $output);

        $this->assertArrayHasKey('name', $output[0]);
        $this->assertArrayHasKey('homeworld', $output[0]);

        $this->assertEquals(self::HUMAN_DATA['name'], $output[0]['name']);
        $this->assertEquals($this->coruscantData['name'], $output[0]['homeworld']);
    }

    /**
     * Test Mammal Species Available With Next
     *
     * @return void
     */
    public function testWithValidMammalAndNext()
    {
        Http::fake([
            config('swapi.all_species_api') => Http::response($this->resultWithMammal, 200),
            'http://swapi.dev/api/species/?page=2' => Http::response($this->resultMammalNext, 200),
            'http://swapi.dev/api/planets/9/' => Http::response($this->coruscantData, 200),
            'http://swapi.dev/api/planets/31/' => Http::response($this->monCalaData, 200)
        ]);
        $output = (new MainService())->getAllMammals();
        $this->assertCount(1, $output);

        $this->assertArrayHasKey('name', $output[0]);
        $this->assertArrayHasKey('homeworld', $output[0]);

        $this->assertEquals(self::HUMAN_DATA['name'], $output[0]['name']);
        $this->assertEquals($this->coruscantData['name'], $output[0]['homeworld']);
    }
}
