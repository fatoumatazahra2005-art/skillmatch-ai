<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $fillable = [
        'user_id',
        'bio',
        'experience_years',
        'education',
        'github_url',
        'linkedin_url',
        'location',
        'availability',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'profile_skills')
            ->withPivot('level', 'years_experience')
            ->withTimestamps();
    }
}
