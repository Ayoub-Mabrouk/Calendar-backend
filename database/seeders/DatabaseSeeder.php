<?php

namespace Database\Seeders;

use App\Models\Calendar;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run($number)
    {
        User::factory($number)->create()->each(function ($user) {
            $id = $user->id;
            Calendar::factory(2)->state(['user_id' => $id])->create()->each(function ($calendar) {
                Event::factory(4)->state(['calendar_id' => $calendar->id])->create();
            });
        });
    }
}
