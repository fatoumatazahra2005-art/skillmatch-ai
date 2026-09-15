<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectMatch;
use App\Services\AIService;
use Illuminate\Http\Request;

class ProjectMatchingService
{

    public function __construct(
        private AIService $aiService
    ) {
    }
    public function calculate(Profile $profile, Project $project)
    {
        $profileSkills = $profile->skills;
        $projectSkills = $project->skills;

        $profileSkillIds = $profileSkills->pluck('id');
        $projectSkillIds = $projectSkills->pluck('id');

        $matchedSkillIds = $profileSkillIds->intersect($projectSkillIds);

        $matchedSkills = $profileSkills->whereIn('id', $matchedSkillIds);

        $missingSkillIds = $projectSkillIds->diff($profileSkillIds);

        $missingSkills = $projectSkills->whereIn('id', $missingSkillIds);

        $matchedSkillNames = $matchedSkills
            ->pluck('name')
            ->values()
            ->all();

        $missingSkillNames = $missingSkills
            ->pluck('name')
            ->values()
            ->all();

        $score = $projectSkills->count() > 0
            ? ($matchedSkills->count() / $projectSkills->count()) * 100
            : 0;

        $aiAnalysis = $this->aiService->analyzeProjectMatch(
            $profileSkills->pluck('name')->values()->all(),
            $projectSkills->pluck('name')->values()->all()
        );

        ProjectMatch::updateOrCreate(
            [
                'profile_id' => $profile->id,
                'project_id' => $project->id,
            ],
            [
                'score' => round($score, 2),
                'matched_skills' => $matchedSkillNames,
                'missing_skills' => $missingSkillNames,
                'explanation' => $aiAnalysis['explanation'] ?? null,
            ]
        );

        return [
            'score' => round($score, 2),
            'matched_skills' => $matchedSkillNames,
            'missing_skills' => $missingSkillNames,
            'explanation' => $aiAnalysis['explanation'] ?? null,
        ];
    }

    public function getByProfile(Profile $profile, Request $request)
    {
        if ($profile->user_id !== $request->user()->id) {
            abort(403, 'Vous ne pouvez pas consulter les matchs de ce profil.');
        }

        return ProjectMatch::with('project')
            ->where('profile_id', $profile->id)
            ->orderByDesc('score')
            ->get();
    }

}
