<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TalentSeeder::class,
            UserSeeder::class,
            CompetitionSeeder::class,
            SubmissionSeeder::class,
        ]);
    }
}