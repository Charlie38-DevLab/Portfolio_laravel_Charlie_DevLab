<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JourneySeeder;
use App\Models\EducationSeeder;
use App\Models\ExperienceSeeder;

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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);


        $this->call([
            // ... vos autres seeders ...
            // AboutSeeder::class, // ou AboutSeederNoExperience::class
            AdminSeeder::class,
            SkillsSeeder::class,
            AboutSeeder::class,
            
        ]);
    }
}
