<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Journey;
use App\Models\Education;
use App\Models\Experience;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Désactiver les contraintes FK
        |--------------------------------------------------------------------------
        */
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Journey::truncate();
        Education::truncate();
        Experience::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        /*
        |--------------------------------------------------------------------------
        | PARCOURS (Journeys)
        |--------------------------------------------------------------------------
        */
        $journeys = [
            [
                'year' => '2025 - Présent',
                'title' => 'Développeur Fullstack & Formateur',
                'description' => 'Création de solutions web innovantes et accompagnement de développeurs débutants. Formation sur Laravel, React et bonnes pratiques.',
                'ordre' => 1,
                'is_active' => true,
            ],
            [
                'year' => '2024',
                'title' => 'Licence 3 Système Informatique & Logiciel',
                'description' => 'Architecture logicielle, bases de données avancées et développement d’applications complexes.',
                'ordre' => 2,
                'is_active' => true,
            ],
            [
                'year' => '2023',
                'title' => 'Licence 2 Sciences de l’Éducation',
                'description' => 'Compétences pédagogiques pour la transmission des savoirs techniques.',
                'ordre' => 3,
                'is_active' => true,
            ],
            [
                'year' => '2022',
                'title' => 'Premiers Projets Freelance',
                'description' => 'Réalisation de sites et applications pour des clients locaux.',
                'ordre' => 4,
                'is_active' => true,
            ],
            [
                'year' => '2020',
                'title' => 'Début de l’Aventure',
                'description' => 'Découverte du développement web : HTML, CSS, JavaScript, PHP.',
                'ordre' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($journeys as $journey) {
            Journey::create($journey);
        }

        /*
        |--------------------------------------------------------------------------
        | FORMATIONS (Educations)
        |--------------------------------------------------------------------------
        */
        $educations = [
            [
                'degree' => 'Licence 3 Système Informatique & Logiciel',
                'school' => 'Université d’Abomey-Calavi',
                'description' => 'Développement logiciel, bases de données, systèmes et web.',
                'icon' => '🎓',
                'ordre' => 1,
                'is_active' => true,
            ],
            [
                'degree' => 'Licence 2 Sciences de l’Éducation',
                'school' => 'Université d’Abomey-Calavi',
                'description' => 'Méthodes pédagogiques et psychologie de l’apprentissage.',
                'icon' => '📚',
                'ordre' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($educations as $education) {
            Education::create($education);
        }

        /*
        |--------------------------------------------------------------------------
        | EXPÉRIENCES (Experiences)
        |--------------------------------------------------------------------------
        */
        $experiences = [
            [
                'company' => 'Charlie DevLab',
                'position' => 'Développeur Web Freelance',
                'period' => '2022 - Présent',
                'description' => 'Conception et développement de solutions web sur mesure (Laravel, React, MySQL).',
                'location' => 'Abomey-Calavi, Bénin',
                'ordre' => 1,
                'is_active' => true,
            ],
            [
                'company' => 'Charlie DevLab Academy',
                'position' => 'Formateur en Développement Web',
                'period' => '2023 - Présent',
                'description' => 'Formation de développeurs juniors aux technologies web modernes.',
                'location' => 'En ligne & Présentiel',
                'ordre' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($experiences as $experience) {
            Experience::create($experience);
        }

        /*
        |--------------------------------------------------------------------------
        | Infos console
        |--------------------------------------------------------------------------
        */
        $this->command->info('✅ AboutSeeder exécuté avec succès');
        $this->command->info('📊 Journeys : ' . Journey::count());
        $this->command->info('📊 Educations : ' . Education::count());
        $this->command->info('📊 Experiences : ' . Experience::count());
    }
}
