<?php

use App\Services\ImportCSVService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatedCharactersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('updated_character_data')->truncate();

        $data = (new ImportCSVService())::import(config('constant.updated_characters_csv'));

        if (!is_null($data)) {
            Log::info('Inserting ' . count($data) . ' entries inside updated_character_data table');
            DB::table('updated_character_data')->insert($data->toArray());
        }
    }
}
