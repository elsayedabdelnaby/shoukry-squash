<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'id' => 1,
            'name' => 'Waterway',
            'address' => '2FRH+C6V, New Cairo 1, Cairo Governorate 4740211, Egypt',
            'location' => 'https://www.google.com/maps?q=30.0409202575684,31.478120803833',
            'starting_at' => '10:00',
            'ending_at' => '22:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Branch::create([
            'id' => 2,
            'name' => 'Maxim',
            'address' => '2FHX+M56, Second New Cairo, Cairo Governorate 4741002, Egypt',
            'location' => 'https://maps.app.goo.gl/zJD73xGFeaCp2tgE9?g_st=iw',
            'starting_at' => '10:00',
            'ending_at' => '22:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
