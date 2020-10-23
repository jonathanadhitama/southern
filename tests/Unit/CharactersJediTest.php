<?php

namespace Tests\Unit;

use App\Services\MainService;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\TestCase;

class CharactersJediTest extends \Tests\TestCase
{
    private $resultMovieNotAvailable = [
        "count" => 1,
        "next" => null,
        "previous" => null,
        "results" => [
            [
                "title" => "A New Hope",
                "episode_id" => 4,
                "opening_crawl" => "It is a period of civil war.",
                "director" => "George Lucas",
                "producer" => "Gary Kurtz, Rick McCallum",
                "release_date" => "1977-05-25",
                "characters" => [
                    "http://swapi.dev/api/people/1/",
                    "http://swapi.dev/api/people/2/",
                ]
            ]
        ]
    ];

    private $resultMovieAvailableButEmptyCharacters = [
        "count" => 2,
        "next" => null,
        "previous" => null,
        "results" => [
            [
                "title" => "A New Hope",
                "episode_id" => 4,
                "opening_crawl" => "It is a period of civil war.",
                "director" => "George Lucas",
                "producer" => "Gary Kurtz, Rick McCallum",
                "release_date" => "1977-05-25",
                "characters" => [
                    "http://swapi.dev/api/people/1/",
                    "http://swapi.dev/api/people/2/",
                ]
            ],
            [
                "title" => "Return of the Jedi",
                "episode_id" => 6,
                "opening_crawl" => "Luke Skywalker has returned to his",
                "director" => "Richard Marquand",
                "producer" => "Howard G. Kazanjian, George Lucas, Rick McCallum",
                "release_date" => "1983-05-25",
                "characters" => [
                ]
            ]
        ]
    ];

    private $resultMovieAvailable = [
        "count" => 2,
        "next" => null,
        "previous" => null,
        "results" => [
            [
                "title" => "A New Hope",
                "episode_id" => 4,
                "opening_crawl" => "It is a period of civil war.",
                "director" => "George Lucas",
                "producer" => "Gary Kurtz, Rick McCallum",
                "release_date" => "1977-05-25",
                "characters" => [
                    "http://swapi.dev/api/people/1/",
                    "http://swapi.dev/api/people/2/",
                ]
            ],
            [
                "title" => "Return of the Jedi",
                "episode_id" => 6,
                "opening_crawl" => "Luke Skywalker has returned to his",
                "director" => "Richard Marquand",
                "producer" => "Howard G. Kazanjian, George Lucas, Rick McCallum",
                "release_date" => "1983-05-25",
                "characters" => [
                    "http://swapi.dev/api/people/1/",
                    "http://swapi.dev/api/people/2/",
                ]
            ]
        ]
    ];

    private $lukeData = [
        "name" => "Luke Skywalker",
        "height" => "172",
        "mass" => "77",
        "hair_color" => "blond",
        "skin_color" => "fair",
        "eye_color" => "blue",
        "birth_year" => "19BBY",
        "gender" => "male",
    ];

    private $C3POData = [
        "name" => "C-3PO",
        "height" => "167",
        "mass" => "75",
        "hair_color" => "n/a",
        "skin_color" => "gold",
        "eye_color" => "yellow",
        "birth_year" => "112BBY",
        "gender" => "n/a",
    ];

    /**
     * Test Movie Data not available
     *
     * @return void
     */
    public function testMovieNotAvailable()
    {
        Http::fake([
            config('swapi.all_films_api') => Http::response($this->resultMovieNotAvailable, 200)
        ]);
        $this->assertCount(0, (new MainService())->getAllCharacters());
    }

    /**
     * Test Movie Data available, but empty character list
     *
     * @return void
     */
    public function testMovieAvailableButEmptyCharacters()
    {
        Http::fake([
            config('swapi.all_films_api') => Http::response($this->resultMovieAvailableButEmptyCharacters, 200)
        ]);
        $this->assertCount(0, (new MainService())->getAllCharacters());
    }

    /**
     * Test valid data
     *
     * @return void
     */
    public function testMovieAvailableWithCharacters()
    {
        Http::fake([
            config('swapi.all_films_api') => Http::response($this->resultMovieAvailable, 200),
            'http://swapi.dev/api/people/1/' => Http::response($this->lukeData, 200),
            'http://swapi.dev/api/people/2/' => Http::response($this->C3POData, 200),
        ]);
        $output = (new MainService())->getAllCharacters();
        $this->assertCount(2, $output);
        $this->assertContains('Luke Skywalker', $output);
        $this->assertContains('C-3PO', $output);
    }
}
