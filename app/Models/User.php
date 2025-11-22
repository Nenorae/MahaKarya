<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Atau Fortify/Jetstream traits
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    // 1. Agar URL otomatis pakai username (mahakarya.test/u/ganendra)
    public function getRouteKeyName()
    {
        return 'username';
    }

    // 2. Relasi ke Profile (One-to-One)
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // 3. Relasi ke Portfolio (One-to-Many)
    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    // 4. Relasi ke Skill (Many-to-Many - Kompetensi User)
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_user');
    }

    // 5. Relasi Follow (User mengikuti siapa)
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    // 6. Relasi Followers (Siapa yang mengikuti user ini)
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }
}
