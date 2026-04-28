<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Evaluation;
use App\Models\Note;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        // ── 1. Admin ──
        User::updateOrCreate(
            ['email' => 'admin@ecole.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // ── 2. Classes ──
        $userClasses = ['1BACSEF-1', '1BACSEF-2', '1BACSEF-3', '2BACSPF-1', '2BACSPF-2', '2BACSPF-3', 'TCSF-1', 'TCSF-2', 'TCSF-3'];
        $classes = Classe::whereIn('nom', $userClasses)->get();

        // ── 3. Matières ──
        $subjectsData = [
            ['nom' => 'ASSIDUITE ET CONDUITE', 'coeff' => 1],
            ['nom' => 'EDUCATION PHYSIQUE', 'coeff' => 1],
            ['nom' => 'HISTOIRE GEOGRAPHIE', 'coeff' => 2],
            ['nom' => 'INSTRUCTION ISLAMIQUE', 'coeff' => 2],
            ['nom' => 'LANGUE ANGLAISE', 'coeff' => 3],
            ['nom' => 'LANGUE ARABE', 'coeff' => 4],
            ['nom' => 'LANGUE FRANCAISE', 'coeff' => 4],
            ['nom' => 'MATHEMATIQUES', 'coeff' => 5],
            ['nom' => 'PHILOSOPHIE', 'coeff' => 2],
            ['nom' => 'PHYSIQUE CHIMIE', 'coeff' => 4],
            ['nom' => 'SC. DE LA VIE ET DE LA TERRE', 'coeff' => 4],
        ];

        $matieres = [];
        foreach ($subjectsData as $data) {
            $matieres[] = Matiere::updateOrCreate(
                ['nom' => $data['nom']],
                ['coefficient' => $data['coeff']]
            );
        }

        // Add 2 teachers per matiere
        $teacherCounter = 0;
        foreach ($matieres as $matiere) {
            for ($i = 0; $i < 2; $i++) {
                $nom = $faker->lastName;
                $prenom = $faker->firstName;
                $email = "prof.fake.{$teacherCounter}@ecole.com";
                $teacherCounter++;
                
                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $prenom . ' ' . $nom,
                        'password' => Hash::make('password'),
                        'role' => 'enseignant',
                    ]
                );

                $enseignants[] = Enseignant::updateOrCreate(
                    ['email' => $email],
                    [
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'user_id' => $user->id,
                        'matiere_id' => $matiere->id,
                    ]
                );
            }
        }

        // ── 5. Students ──
        $eleves = [];
        $studentCounter = 0;

        // Add 10 students for each user created class
        foreach ($classes as $classe) {
            for ($i = 0; $i < 10; $i++) {
                $nom = $faker->lastName;
                $prenom = $faker->firstName;
                $email = "eleve.fake.{$studentCounter}@ecole.com";
                $studentCounter++;
                
                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $prenom . ' ' . $nom,
                        'password' => Hash::make('password'),
                        'role' => 'eleve',
                    ]
                );

                $eleves[] = Eleve::updateOrCreate(
                    ['email' => $email],
                    [
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'date_naissance' => $faker->dateTimeBetween('-18 years', '-12 years')->format('Y-m-d'),
                        'classe_id' => $classe->id,
                        'user_id' => $user->id,
                    ]
                );
            }
        }

        // ── 6. Grades (CC1, CC2, CC3) ──
        foreach ($eleves as $eleve) {
            foreach ($matieres as $matiere) {
                // Generate some grades for some subjects
                if (rand(0, 10) > 2) {
                    Note::updateOrCreate(
                        ['id_eleve' => $eleve->id, 'matiere_id' => $matiere->id],
                        [
                            'cc1' => round(rand(80, 200) / 10, 1),
                            'cc2' => rand(0, 1) ? round(rand(80, 200) / 10, 1) : null,
                            'cc3' => rand(0, 1) ? round(rand(80, 200) / 10, 1) : null,
                        ]
                    );
                }
            }
        }
    }
}
