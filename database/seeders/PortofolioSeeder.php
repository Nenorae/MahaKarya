<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Skill;
use App\Models\Portfolio; // Pastikan Model Portfolio di-import

class PortofolioSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User
        $me = User::create([
            'name' => 'Ganendra Dev',
            'username' => 'sinen',
            'email' => 'admin@mahakarya.test',
            'password' => bcrypt('password'),
        ]);

        // 2. Buat Profil
        $me->profile()->create([
            'headline' => 'Fullstack Developer',
            'bio' => 'Suka ngoding Laravel sampai pagi.',
            'institution' => 'PENS',
            'social_links' => ['github' => 'https://github.com', 'linkedin' => 'https://linkedin.com']
        ]);

        // 3. Buat Skill
        $laravel = Skill::create(['name' => 'Laravel', 'slug' => 'laravel']);
        $react = Skill::create(['name' => 'React', 'slug' => 'react']);

        // 4. Buat Portfolio (PERBAIKAN DI SINI)
        // Gunakan nama method relasi yang benar (biasanya 'portfolios' lowercase)
        $p1 = $me->portfolios()->create([
            'title' => 'Aplikasi E-Kantin',
            'slug' => 'aplikasi-e-kantin',
            'description' => 'Sistem manajemen kantin kampus.',
            'thumbnail_path' => null,
        ]);

        // 5. Attach Skill ke Portfolio
        $p1->skills()->attach([$laravel->id, $react->id]);
    }
}
