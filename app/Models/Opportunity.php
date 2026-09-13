<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    protected $fillable = [
        'title',
        'description',
        'company',
        'type',
        'location',
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'opportunity_skills')
            ->withPivot('level')
            ->withTimestamps();
    }
}
