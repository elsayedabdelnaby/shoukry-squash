<?php

namespace Database\Seeders;

use App\Models\Objective;
use Illuminate\Database\Seeder;

class ObjectivesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Objective::insert([
            [
                'id' => 1,
                'objective' => 'To prepare young junior players to compete at the highest level attainable while securing spots for them at esteemed universities with strong squash programs.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'objective' => 'To deliver a unique quality of squash for those who want to pursue a professional career and excel as well as taking their level to a higher mark.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'objective' => 'Delivering an unforgettable experience to players, coaches and adults who share passion for squash.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'objective' => 'SSA\'s main goal is to deliver higher squash quality for individuals with different cultures and backgrounds through establishing various branches worldwide.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
