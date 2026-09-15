<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectSkillService
{
    public function addSkill(Project $project, Request $request)
    {

        if ($project->user_id !== $request->user()->id) {
            abort(403, 'Vous ne pouvez pas modifier ce projet.');
        }
        $validated = $request->validate([
            'skill_id' => 'required|exists:skills,id',
            'level' => 'required|string',
        ]);

        $project->skills()->syncWithoutDetaching([
            $validated['skill_id'] => [
                'level' => $validated['level'],
            ],
        ]);

        return $project->load('skills');
    }

}
