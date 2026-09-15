<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'category',
    ];
    public function profiles()

    {
        return $this->belongsToMany(Profile::class, 'profile_skills')
            ->withPivot('level', 'years_experience')
            ->withTimestamps();
    }

    public function opportunities()
    {
        return $this->belongsToMany(Opportunity::class, 'opportunity_skills')
            ->withPivot('level')
            ->withTimestamps();
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_skills')
            ->withPivot('level')
            ->withTimestamps();
    }
}
