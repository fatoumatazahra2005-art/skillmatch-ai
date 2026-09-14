<?php

namespace App\Services;

use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunitySkillService
{
    public function addSkill(Opportunity $opportunity, Request $request)
    {
        $validated = $request->validate([
            'skill_id' => 'required|exists:skills,id',
            'level' => 'required|string',
        ]);

        $opportunity->skills()->syncWithoutDetaching([
            $validated['skill_id'] => [
                'level' => $validated['level'],
            ],
        ]);

        return $opportunity->load('skills');
    }

}
