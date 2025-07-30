<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Player;

class PlayersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $players = [
            [
                'name' => 'Ahmed Mohamed',
                'phone' => '01012345678',
                'birth_date' => '2010-05-15',
                'nationality' => 'Egyptian',
                'gender' => 'male',
                'parents_contact_number' => '01098765432',
            ],
            [
                'name' => 'Fatima Ali',
                'phone' => '01023456789',
                'birth_date' => '2012-08-22',
                'nationality' => 'Egyptian',
                'gender' => 'female',
                'parents_contact_number' => '01087654321',
            ],
            [
                'name' => 'Omar Hassan',
                'phone' => '01034567890',
                'birth_date' => '2009-03-10',
                'nationality' => 'Egyptian',
                'gender' => 'male',
                'parents_contact_number' => '01076543210',
            ],
            [
                'name' => 'Aisha Mahmoud',
                'phone' => '01045678901',
                'birth_date' => '2011-12-05',
                'nationality' => 'Egyptian',
                'gender' => 'female',
                'parents_contact_number' => '01065432109',
            ],
            [
                'name' => 'John Smith',
                'phone' => '01056789012',
                'birth_date' => '2010-07-18',
                'nationality' => 'Other',
                'gender' => 'male',
                'parents_contact_number' => '01054321098',
            ],
            [
                'name' => 'Sarah Johnson',
                'phone' => '01067890123',
                'birth_date' => '2013-01-30',
                'nationality' => 'Other',
                'gender' => 'female',
                'parents_contact_number' => '01043210987',
            ],
        ];

        foreach ($players as $playerData) {
            Player::create($playerData);
        }
    }
}
