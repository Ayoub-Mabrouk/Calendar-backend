<?php

namespace App\Console\Commands;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Console\Command;

class createusers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:users {number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $number = $this->argument('number');

            $db = new DatabaseSeeder();

            $db->run($number);

            $this->info("{$number} users, calendars and events are successfully created");
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }

        return 0;
    }
}
