<?php

namespace App\Console\Commands;

use App\Services\MainService;
use Illuminate\Console\Command;

class UpdateCharactersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:characters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates characters in table swapi_characters from table updated_character_data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $output = (new MainService())->updateCharactersToDB();
        if ($output['success']) {
            $this->info($output['messages'][0]);
        } else {
            foreach ($output['messages'] as $message) {
                $this->error($message);
            }
        }
    }
}
