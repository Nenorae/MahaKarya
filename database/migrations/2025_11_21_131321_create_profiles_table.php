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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke Users
            // onDelete('cascade') artinya jika User dihapus, Profilenya ikut terhapus otomatis
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('headline')->nullable(); // Contoh: "Informatics Student at PENS"
            $table->text('bio')->nullable();

            // Path penyimpanan gambar
            $table->string('avatar_path', 2048)->nullable();
            $table->string('cover_path', 2048)->nullable();

            // Data Akademik
            $table->string('institution')->nullable(); // Kampus
            $table->string('major')->nullable();       // Jurusan

            // MySQL mendukung kolom JSON. Sangat berguna untuk menyimpan link sosmed yang dinamis
            // Contoh isi: {"linkedin": "url...", "github": "url...", "instagram": "url..."}
            $table->json('social_links')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
