<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'usage_count'];

    // Skill ini dimiliki oleh user siapa saja?
    public function users()
    {
        return $this->belongsToMany(User::class, 'skill_user');
    }

    // Skill ini dipakai di proyek apa saja?
    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class, 'portfolio_skill');
    }

}
