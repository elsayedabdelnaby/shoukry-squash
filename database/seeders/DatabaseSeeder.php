<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SuperAdminSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(BranchesSeeder::class);
        $this->call(ObjectivesSeeder::class);
        $this->call(MissionsSeeder::class);
    }
}
