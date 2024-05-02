<?php

namespace Database\Seeders;

use App\Models\Practice;
use App\Models\Movie;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(ScreenTableSeeder::class);
        Practice::factory(10)->create();
//        Movie::factory(25)->create();
        Schedule::factory(50)->create();

        $this->call(SheetTableSeeder::class);
    }
}
