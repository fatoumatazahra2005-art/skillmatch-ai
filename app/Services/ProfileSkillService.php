<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileSkillService
{
    public function addSkill(Profile $profile, Request $request)
    {

        if ($profile->user_id !== $request->user()->id) {
            abort(403, 'Vous ne pouvez pas modifier ce profil.');
        }

        $validated = $request->validate([
            'skill_id' => 'required|exists:skills,id',
            'level' => 'required|string',
            'years_experience' => 'nullable|integer|min:0',
        ]);

        $profile->skills()->syncWithoutDetaching([
            $validated['skill_id'] => [
                'level' => $validated['level'],
                'years_experience' => $validated['years_experience'] ?? 0,
            ],
        ]);

        return $profile->load('skills');
    }

}
