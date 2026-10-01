<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'code'        => 'informatique',
                'name'        => 'Bac Informatique',
                'short_name'  => 'Info',
                'description' => 'Programme complet de la section Sciences de l\'Informatique.',
                'color'       => '#FDE047',
                'order'       => 1,
                'is_active'   => true,
            ],
            [
                'code'        => 'scientifique',
                'name'        => 'Bac Scientifique',
                'short_name'  => 'Sci',
                'description' => 'Programme adapté aux sections Mathématiques, Sciences Expérimentales et Techniques.',
                'color'       => '#4ADE80',
                'order'       => 2,
                'is_active'   => true,
            ],
        ];

        foreach ($sections as $section) {
            Section::updateOrCreate(
                ['code' => $section['code']],
                $section
            );
        }

        $this->command->info('✅ Sections créées : ' . Section::count());
    }
}