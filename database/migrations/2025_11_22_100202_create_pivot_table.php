<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. PIVOT: PORTFOLIO_SKILL
        // Tabel ini mencatat: "Proyek A menggunakan Skill X dan Skill Y"
        Schema::create('portfolio_skill', function (Blueprint $table) {
            $table->id();

            $table->foreignId('portfolio_skill_id')->nullable(); // Helper col (opsional)

            // Relasi ke Portfolio
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');

            // Relasi ke Skill
            // Jika Skill "Laravel" dihapus dari master, tag di semua proyek ikut hilang
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');

            // Mencegah duplikasi: Satu proyek tidak bisa punya skill "PHP" dua kali
            $table->unique(['portfolio_id', 'skill_id']);
        });

        // 2. PIVOT: FOLLOWS (User mengikuti User)
        Schema::create('follows', function (Blueprint $table) {
            // Siapa yang nge-follow (follower)
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');

            // Siapa yang di-follow (following)
            $table->foreignId('following_id')->constrained('users')->onDelete('cascade');

            $table->timestamp('created_at')->useCurrent();

            // Mencegah user follow orang yang sama berkali-kali
            $table->primary(['follower_id', 'following_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_skill');
        Schema::dropIfExists('follows');
    }
};
