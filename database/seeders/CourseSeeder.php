<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Section;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les 2 sections
        $informatique = Section::where('code', 'informatique')->first();
        $scientifique = Section::where('code', 'scientifique')->first();

        if (!$informatique || !$scientifique) {
            $this->command->error('❌ Sections introuvables. Lance d\'abord SectionSeeder.');
            return;
        }

        // ═══════════════════════════════════════════
        // 🖥️  BAC INFORMATIQUE — 20 chapitres
        // ═══════════════════════════════════════════
        $infoCourses = [
            [
                'title'          => 'Algorithmique',
                'description'    => 'Introduction à la pensée algorithmique : définitions, étapes de résolution et premiers concepts.',
                'category'       => 'Fondamentaux',
                'category_color' => 'text-brandCyber',
                'duration'       => 30,
                'lessons'        => 5,
            ],
            [
                'title'          => 'Variables & types',
                'description'    => 'Comprendre les variables, les types de données et leur déclaration en Python.',
                'category'       => 'Fondamentaux',
                'category_color' => 'text-brandCyber',
                'duration'       => 35,
                'lessons'        => 6,
            ],
            [
                'title'          => 'Entrées / sorties',
                'description'    => 'Maîtriser input() et print() : lire les données de l\'utilisateur et afficher des résultats.',
                'category'       => 'Fondamentaux',
                'category_color' => 'text-brandCyber',
                'duration'       => 25,
                'lessons'        => 4,
            ],
            [
                'title'          => 'Opérateurs',
                'description'    => 'Opérateurs arithmétiques, de comparaison et logiques : le cœur des expressions Python.',
                'category'       => 'Fondamentaux',
                'category_color' => 'text-brandCyber',
                'duration'       => 30,
                'lessons'        => 5,
            ],
            [
                'title'          => 'Conditions',
                'description'    => 'Structures conditionnelles if / elif / else : orienter le flux d\'exécution.',
                'category'       => 'Contrôle du flux',
                'category_color' => 'text-amber-400',
                'duration'       => 40,
                'lessons'        => 6,
            ],
            [
                'title'          => 'Boucles',
                'description'    => 'Boucles for et while : répétition, itérations et contrôle avec break / continue.',
                'category'       => 'Contrôle du flux',
                'category_color' => 'text-amber-400',
                'duration'       => 50,
                'lessons'        => 7,
            ],
            [
                'title'          => 'Chaînes',
                'description'    => 'Manipulation des chaînes de caractères : slicing, méthodes et formatage.',
                'category'       => 'Structures',
                'category_color' => 'text-brandMint',
                'duration'       => 35,
                'lessons'        => 5,
            ],
            [
                'title'          => 'Tableaux',
                'description'    => 'Listes en Python : création, parcours, manipulation et opérations courantes.',
                'category'       => 'Structures',
                'category_color' => 'text-brandMint',
                'duration'       => 45,
                'lessons'        => 6,
            ],
            [
                'title'          => 'Recherche',
                'description'    => 'Algorithmes de recherche séquentielle et dichotomique : efficacité et implémentation.',
                'category'       => 'Algorithmes',
                'category_color' => 'text-purple-400',
                'duration'       => 40,
                'lessons'        => 5,
            ],
            [
                'title'          => 'Tri',
                'description'    => 'Algorithmes de tri : sélection, insertion, à bulles et leurs complexités.',
                'category'       => 'Algorithmes',
                'category_color' => 'text-purple-400',
                'duration'       => 55,
                'lessons'        => 6,
            ],
            [
                'title'          => 'Modularité',
                'description'    => 'Fonctions et procédures : décomposition, paramètres, retour de valeurs et portée.',
                'category'       => 'Algorithmes',
                'category_color' => 'text-purple-400',
                'duration'       => 45,
                'lessons'        => 6,
            ],
            [
                'title'          => 'Récursivité',
                'description'    => 'Fonctions récursives : principe, cas de base et applications classiques.',
                'category'       => 'Algorithmes',
                'category_color' => 'text-purple-400',
                'duration'       => 50,
                'lessons'        => 6,
            ],
            [
                'title'          => 'Algorithmes arithmétiques',
                'description'    => 'PGCD, PPCM, nombres premiers, décomposition en facteurs premiers.',
                'category'       => 'Mathématiques',
                'category_color' => 'text-blue-400',
                'duration'       => 40,
                'lessons'        => 5,
            ],
            [
                'title'          => 'Algorithmes récurrents',
                'description'    => 'Suites récurrentes : calcul des termes, convergence et applications.',
                'category'       => 'Mathématiques',
                'category_color' => 'text-blue-400',
                'duration'       => 35,
                'lessons'        => 4,
            ],
            [
                'title'          => 'Approximation',
                'description'    => 'Méthodes numériques : dichotomie, Newton, calcul approché de racines.',
                'category'       => 'Mathématiques',
                'category_color' => 'text-blue-400',
                'duration'       => 45,
                'lessons'        => 5,
            ],
            [
                'title'          => 'Tableaux 2D',
                'description'    => 'Matrices en Python : création, parcours, opérations et algorithmes matriciels.',
                'category'       => 'Structures avancées',
                'category_color' => 'text-cyan-400',
                'duration'       => 50,
                'lessons'        => 6,
            ],
            [
                'title'          => 'Enregistrements / fichiers',
                'description'    => 'Structures de données composées et gestion des fichiers (lecture / écriture).',
                'category'       => 'Structures avancées',
                'category_color' => 'text-cyan-400',
                'duration'       => 55,
                'lessons'        => 7,
            ],
            [
                'title'          => 'Révision Bac',
                'description'    => 'Fiches de révision complètes : synthèse de tout le programme en un coup d\'œil.',
                'category'       => 'Préparation Bac',
                'category_color' => 'text-red-400',
                'duration'       => 60,
                'lessons'        => 8,
            ],
            [
                'title'          => 'Sujets Bac',
                'description'    => 'Sujets officiels des sessions précédentes avec corrections détaillées.',
                'category'       => 'Préparation Bac',
                'category_color' => 'text-red-400',
                'duration'       => 90,
                'lessons'        => 10,
            ],
            [
                'title'          => 'Examens blancs',
                'description'    => 'Simulations complètes d\'examens avec chronomètre et correction automatique.',
                'category'       => 'Préparation Bac',
                'category_color' => 'text-red-400',
                'duration'       => 120,
                'lessons'        => 5,
            ],
        ];

        foreach ($infoCourses as $index => $course) {
            Course::updateOrCreate(
                [
                    'section_id' => $informatique->id,
                    'number'     => $index + 1,
                ],
                [
                    'title'          => $course['title'],
                    'description'    => $course['description'],
                    'category'       => $course['category'],
                    'category_color' => $course['category_color'],
                    'duration'       => $course['duration'],
                    'lessons'        => $course['lessons'],
                    'xp_reward'      => 100,
                    'is_active'      => true,
                ]
            );
        }

        // ═══════════════════════════════════════════
        // 🔬 BAC SCIENTIFIQUE — 15 chapitres
        // ═══════════════════════════════════════════
        $sciCourses = [
            [
                'title'          => 'Algorithmique + Python',
                'description'    => 'Introduction à l\'algorithmique et prise en main de Python : ton premier programme.',
                'category'       => 'Fondamentaux',
                'category_color' => 'text-brandMint',
                'duration'       => 35,
                'lessons'        => 5,
            ],
            [
                'title'          => 'Variables + entrées/sorties',
                'description'    => 'Variables, types de données, input() et print() : communiquer avec ton programme.',
                'category'       => 'Fondamentaux',
                'category_color' => 'text-brandMint',
                'duration'       => 40,
                'lessons'        => 6,
            ],
            [
                'title'          => 'Opérateurs',
                'description'    => 'Opérateurs arithmétiques, comparaison et logiques appliqués aux sciences.',
                'category'       => 'Fondamentaux',
                'category_color' => 'text-brandMint',
                'duration'       => 30,
                'lessons'        => 5,
            ],
            [
                'title'          => 'Conditions',
                'description'    => 'Structures conditionnelles if / elif / else et prise de décision algorithmique.',
                'category'       => 'Contrôle du flux',
                'category_color' => 'text-amber-400',
                'duration'       => 35,
                'lessons'        => 5,
            ],
            [
                'title'          => 'Boucles while',
                'description'    => 'La boucle while : répétition conditionnelle et arrêt sur critère.',
                'category'       => 'Contrôle du flux',
                'category_color' => 'text-amber-400',
                'duration'       => 40,
                'lessons'        => 5,
            ],
            [
                'title'          => 'Boucles for',
                'description'    => 'La boucle for : itérations définies, parcours et range().',
                'category'       => 'Contrôle du flux',
                'category_color' => 'text-amber-400',
                'duration'       => 40,
                'lessons'        => 5,
            ],
            [
                'title'          => 'Exercices numériques',
                'description'    => 'Applications aux mathématiques : suites, sommes, calculs approchés.',
                'category'       => 'Applications',
                'category_color' => 'text-purple-400',
                'duration'       => 50,
                'lessons'        => 6,
            ],
            [
                'title'          => 'Chaînes',
                'description'    => 'Manipulation des chaînes de caractères : slicing, méthodes et formatage.',
                'category'       => 'Structures',
                'category_color' => 'text-cyan-400',
                'duration'       => 35,
                'lessons'        => 5,
            ],
            [
                'title'          => 'Tableaux',
                'description'    => 'Listes en Python : création, parcours et manipulation de données.',
                'category'       => 'Structures',
                'category_color' => 'text-cyan-400',
                'duration'       => 45,
                'lessons'        => 6,
            ],
            [
                'title'          => 'Traitement des tableaux',
                'description'    => 'Algorithmes classiques sur les tableaux : min/max, moyenne, occurrences.',
                'category'       => 'Structures',
                'category_color' => 'text-cyan-400',
                'duration'       => 50,
                'lessons'        => 6,
            ],
            [
                'title'          => 'Fonctions',
                'description'    => 'Modularité : définir, appeler et retourner des valeurs avec des fonctions.',
                'category'       => 'Algorithmes',
                'category_color' => 'text-blue-400',
                'duration'       => 45,
                'lessons'        => 6,
            ],
            [
                'title'          => 'Recherche + tri',
                'description'    => 'Algorithmes de recherche et de tri essentiels au programme scientifique.',
                'category'       => 'Algorithmes',
                'category_color' => 'text-blue-400',
                'duration'       => 55,
                'lessons'        => 7,
            ],
            [
                'title'          => 'Problèmes Bac',
                'description'    => 'Problèmes types du Bac scientifique avec méthodologie de résolution.',
                'category'       => 'Préparation Bac',
                'category_color' => 'text-red-400',
                'duration'       => 70,
                'lessons'        => 8,
            ],
            [
                'title'          => 'Sujet Bac guidé',
                'description'    => 'Un sujet Bac complet résolu pas à pas avec explications détaillées.',
                'category'       => 'Préparation Bac',
                'category_color' => 'text-red-400',
                'duration'       => 90,
                'lessons'        => 6,
            ],
            [
                'title'          => 'Examen blanc',
                'description'    => 'Simulation complète d\'examen avec chronomètre et correction automatique.',
                'category'       => 'Préparation Bac',
                'category_color' => 'text-red-400',
                'duration'       => 120,
                'lessons'        => 4,
            ],
        ];

        foreach ($sciCourses as $index => $course) {
            Course::updateOrCreate(
                [
                    'section_id' => $scientifique->id,
                    'number'     => $index + 1,
                ],
                [
                    'title'          => $course['title'],
                    'description'    => $course['description'],
                    'category'       => $course['category'],
                    'category_color' => $course['category_color'],
                    'duration'       => $course['duration'],
                    'lessons'        => $course['lessons'],
                    'xp_reward'      => 100,
                    'is_active'      => true,
                ]
            );
        }

        $this->command->info('✅ Cours créés : ' . Course::count());
        $this->command->info('   - Informatique : ' . Course::where('section_id', $informatique->id)->count());
        $this->command->info('   - Scientifique : ' . Course::where('section_id', $scientifique->id)->count());
    }
}