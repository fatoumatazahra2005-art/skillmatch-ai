<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMatch extends Model
{
    protected $fillable = [
        'profile_id',
        'project_id',
        'score',
        'matched_skills',
        'missing_skills',
        'explanation',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'matched_skills' => 'array',
        'missing_skills' => 'array',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
