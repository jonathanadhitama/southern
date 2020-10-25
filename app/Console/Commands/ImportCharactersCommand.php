<?php

namespace App\Console\Commands;

use App\Services\MainService;
use Illuminate\Console\Command;

class ImportCharactersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:characters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports all characters from SWAPI into table swapi_characters';

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
        $output = (new MainService())->importCharactersToDB();
        if ($output['success']) {
            $this->info($output['messages'][0]);
        } else {
            foreach ($output['messages'] as $message) {
                $this->error($message);
            }
        }
    }
}
