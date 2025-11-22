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
        Schema::create('likes', function (Blueprint $table) {
            // Siapa yang nge-like
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Apa yang di-like
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');

            $table->timestamp('created_at')->useCurrent();

            // Mencegah user nge-like berkali-kali di satu post (Unique Constraint)
            $table->primary(['user_id', 'portfolio_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
