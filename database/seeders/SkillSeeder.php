<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar skill yang ingin dimasukkan
        $skills = [
            'PHP',
            'Laravel',
            'Livewire',
            'JavaScript',
            'Vue.js',
            'Tailwind CSS',
            'Docker',
            'MySQL',
            'Git'
        ];

        // Loop dan masukkan ke database
        foreach ($skills as $skillName) {
            Skill::create([
                'name' => $skillName,
                // Tambahkan kolom lain jika ada, misal: 'category' => 'Backend'
            ]);
        }
    }
}
