<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->isProduction()) {
            throw new \RuntimeException('Demo content seeding is disabled in production.');
        }

        $this->call([
            CaseSeeder::class,
            ServiceSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
