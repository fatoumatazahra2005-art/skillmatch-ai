<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobMatch extends Model
{
    protected $fillable = [
        'profile_id',
        'opportunity_id',
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

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }
}
