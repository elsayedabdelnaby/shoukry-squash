<?php

namespace Database\Seeders;

use App\Models\Mission;
use Illuminate\Database\Seeder;

class MissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mission::insert([
            [
                'id' => 1,
                'mission' => 'To foster ethics of hard-work, tuition, and core values that would ensure players a unique experience at the highest level of Squash.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'mission' => 'We believe that through Squash, players can attain scholarships that would enable them to pursue elite universities that can deliver rich education & squash programs.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'mission' => 'SSA aims to ensure juniors, adults, and pros a high quality of squash within an environment that promotes sportsmanship, virtue, and mental toughness.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
