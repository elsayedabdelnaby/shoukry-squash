<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate([
            'id' => 1,
            'phone_number' => '01006559069',
            'facebook_page' => 'https://www.facebook.com/shoukrysquashacademy/',
            'instagram_page' => 'https://www.instagram.com/shoukrysquashacademy',
            'members_count' => 100,
            'experience_years' => 8,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
