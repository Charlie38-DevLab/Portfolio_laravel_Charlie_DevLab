<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SkillCategory;
use App\Models\Skill;

class SkillsSeeder extends Seeder
{
    public function run(): void
    {
        // Frontend
        $frontend = SkillCategory::create([
            'name' => 'Frontend',
            'slug' => 'frontend',
            'icon' => '🎨',
            'color' => '#667EEA, #764BA2',
            'order' => 1,
        ]);

        Skill::create(['skill_category_id' => $frontend->id, 'name' => 'HTML/CSS', 'level' => 95, 'order' => 1]);
        Skill::create(['skill_category_id' => $frontend->id, 'name' => 'JavaScript', 'level' => 90, 'order' => 2]);
        Skill::create(['skill_category_id' => $frontend->id, 'name' => 'React.js', 'level' => 88, 'order' => 3]);
        Skill::create(['skill_category_id' => $frontend->id, 'name' => 'Vue.js', 'level' => 82, 'order' => 4]);
        Skill::create(['skill_category_id' => $frontend->id, 'name' => 'Tailwind CSS', 'level' => 92, 'order' => 5]);

        // Backend
        $backend = SkillCategory::create([
            'name' => 'Backend',
            'slug' => 'backend',
            'icon' => '⚙️',
            'color' => '#00D4AA, #00B8A9',
            'order' => 2,
        ]);

        Skill::create(['skill_category_id' => $backend->id, 'name' => 'PHP', 'level' => 88, 'order' => 1]);
        Skill::create(['skill_category_id' => $backend->id, 'name' => 'Laravel', 'level' => 85, 'order' => 2]);
        Skill::create(['skill_category_id' => $backend->id, 'name' => 'Node.js', 'level' => 80, 'order' => 3]);
        Skill::create(['skill_category_id' => $backend->id, 'name' => 'Python', 'level' => 75, 'order' => 4]);

        // Base de données
        $database = SkillCategory::create([
            'name' => 'Base De Données',
            'slug' => 'database',
            'icon' => '🗄️',
            'color' => '#A29BFE, #6C5CE7',
            'order' => 3,
        ]);

        Skill::create(['skill_category_id' => $database->id, 'name' => 'MySQL', 'level' => 85, 'order' => 1]);
        Skill::create(['skill_category_id' => $database->id, 'name' => 'PostgreSQL', 'level' => 78, 'order' => 2]);
        Skill::create(['skill_category_id' => $database->id, 'name' => 'MongoDB', 'level' => 72, 'order' => 3]);

        // DevOps
        $devops = SkillCategory::create([
            'name' => 'DevOps',
            'slug' => 'devops',
            'icon' => '🚀',
            'color' => '#FFA500, #FF8B4D',
            'order' => 4,
        ]);

        Skill::create(['skill_category_id' => $devops->id, 'name' => 'Git/GitHub', 'level' => 88, 'order' => 1]);
        Skill::create(['skill_category_id' => $devops->id, 'name' => 'Docker', 'level' => 65, 'order' => 2]);

        // Design
        $design = SkillCategory::create([
            'name' => 'Design',
            'slug' => 'design',
            'icon' => '✨',
            'color' => '#FF6B9D, #FF4757',
            'order' => 5,
        ]);

        Skill::create(['skill_category_id' => $design->id, 'name' => 'Figma', 'level' => 70, 'order' => 1]);

        // Soft Skills
        $softskills = SkillCategory::create([
            'name' => 'Soft Skills',
            'slug' => 'softskills',
            'icon' => '💡',
            'color' => '#00D4FF, #00A8E8',
            'order' => 6,
        ]);

        Skill::create(['skill_category_id' => $softskills->id, 'name' => 'Communication', 'level' => 90, 'order' => 1]);
        Skill::create(['skill_category_id' => $softskills->id, 'name' => "Travail d'équipe", 'level' => 92, 'order' => 2]);
        Skill::create(['skill_category_id' => $softskills->id, 'name' => 'Gestion de projet', 'level' => 80, 'order' => 3]);
    }
}
