<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Vider la table avant d'ajouter des données
        User::truncate();
        
        // 1. Créer un utilisateur admin
        User::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'Admin Presentily',
            'email' => 'admin@presentily.tn',
            'password' => Hash::make('admin123'),
            'school' => 'Lycée Pilote Bourguiba',
            'grade' => 'Bac',
            'governorate' => 'Tunis',
            'total_xp' => 5000,
            'level' => 10,
            'is_premium' => true,
            'subscription_type' => 'annual',
            'subscription_end_date' => now()->addYear(),
            'email_verified_at' => now(),
        ]);

        // 2. Créer un utilisateur de test
        User::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'Fadwa Dhemaid',
            'email' => 'fadwa@lycee.tn',
            'password' => Hash::make('password'),
            'school' => 'Lycée Pilote Bourguiba',
            'grade' => '4eme',
            'governorate' => 'Tunis',
            'total_xp' => 1250,
            'level' => 4,
            'is_premium' => true,
            'subscription_type' => 'annual',
            'subscription_end_date' => now()->addYear(),
            'email_verified_at' => now(),
        ]);

        // 3. Créer 5 utilisateurs aléatoires
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'uuid' => (string) Str::uuid(),
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@test.tn',
                'password' => Hash::make('password'),
                'school' => ['Lycée Pilote Bourguiba', 'Lycée Pilote Sousse', 'Lycée Pilote Sfax'][rand(0, 2)],
                'grade' => ['1ere', '2eme', '3eme', '4eme', 'Bac'][rand(0, 4)],
                'governorate' => ['Tunis', 'Ariana', 'Sfax', 'Sousse', 'Monastir'][rand(0, 4)],
                'total_xp' => rand(0, 5000),
                'level' => rand(1, 10),
                'current_chapter' => rand(1, 5),
                'current_lesson' => rand(1, 10),
                'completed_lessons' => rand(0, 50),
                'completed_exercises' => rand(0, 30),
                'streak_days' => rand(0, 30),
                'last_activity_date' => now()->subDays(rand(0, 30)),
                'avatar_config' => [
                    'hair' => ['short', 'long'][rand(0, 1)],
                    'hairColor' => '#1E1B4B',
                    'skin' => '#F3D2B3',
                    'outfit' => ['hoodie', 'shirt'][rand(0, 1)],
                    'accessory' => ['glasses', 'none'][rand(0, 1)],
                ],
                'badges' => ['python_basics', 'loop_master'],
                'achievements' => [],
                'subscription_type' => ['free', 'semestrial', 'annual'][rand(0, 2)],
                'subscription_end_date' => now()->addDays(rand(30, 365)),
                'is_premium' => rand(0, 1) === 1,
                'email_verified_at' => now(),
                'last_login' => now()->subDays(rand(0, 7)),
            ]);
        }
    }
}