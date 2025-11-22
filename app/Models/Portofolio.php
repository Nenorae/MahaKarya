<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Agar URL project pakai slug (mahakarya.test/p/judul-project)
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Skill/Teknologi yang dipakai di proyek ini
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'portfolio_skill');
    }

    // Siapa saja yang me-like proyek ini
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'portfolio_id', 'user_id');
    }

    // Helper: Cek apakah user tertentu sudah like
    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
