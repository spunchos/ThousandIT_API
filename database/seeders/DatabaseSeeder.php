<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\News;
use App\Models\News_rubric;
use App\Models\Rubric;
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
        // \App\Models\User::factory(10)->create();
        Author::factory(10)->create();
        Rubric::factory(15)->create();
        News::factory(20)->create();
        News_rubric::factory(20)->create();
    }
}
