<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'is_open',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'project_skills')
            ->withPivot('level')
            ->withTimestamps();
    }
    public function matches()
    {
        return $this->hasMany(ProjectMatch::class);
    }
}
