<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
           $table->id();
            
            // Relasi ke User (Pemilik Proyek)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('title');
            $table->string('slug')->unique(); // URL: /p/aplikasi-kasir-pintar
            
            $table->longText('description'); // Deskripsi panjang (bisa support HTML/Markdown)
            
            $table->string('thumbnail_path', 2048)->nullable();
            
            // Link ke demo atau repository
            $table->string('demo_url')->nullable();
            $table->string('repo_url')->nullable();
            
            // Status & Statistik
            $table->boolean('is_published')->default(true);
            $table->unsignedBigInteger('views_count')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
