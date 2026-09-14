<?php

namespace App\Services;
use App\Models\JobMatch;
use App\Models\Opportunity;
use App\Models\Profile;

class JobMatchingService
{
    public function calculate(Profile $profile, Opportunity $opportunity)
    {
        $profileSkills = $profile->skills;
        $opportunitySkills = $opportunity->skills;
        $profileSkillIds = $profileSkills->pluck('id');
        $opportunitySkillIds = $opportunitySkills->pluck('id');

        $matchedSkillIds = $profileSkillIds->intersect($opportunitySkillIds);
        $matchedSkills = $profileSkills->whereIn('id', $matchedSkillIds);
        $missingSkillIds = $opportunitySkillIds->diff($profileSkillIds);
        $missingSkills = $opportunitySkills->whereIn('id', $missingSkillIds);

        $matchedSkillNames = $matchedSkills->pluck('name')->values()->all();

        $missingSkillNames = $missingSkills->pluck('name')->values()->all();

        $score = $opportunitySkills->count() > 0
            ? ($matchedSkills->count() / $opportunitySkills->count()) * 100
            : 0;

        $explanation = $score == 100
            ? 'Le profil possède toutes les compétences demandées par cette opportunité.'
            : 'Le profil possède ' . count($matchedSkillNames) . ' compétence(s) demandée(s) sur ' . $opportunitySkills->count() . '.';

        $result = [
            'score' => round($score, 2),
            'matched_skills' => $matchedSkillNames,
            'missing_skills' => $missingSkillNames,
            'explanation' => $explanation,
        ];
        JobMatch::updateOrCreate(
            [
                'profile_id' => $profile->id,
                'opportunity_id' => $opportunity->id,
            ],
            [
                'score' => $result['score'],
                'matched_skills' => $result['matched_skills'],
                'missing_skills' => $result['missing_skills'],
                'explanation' => $result['explanation'],
            ]
        );

        return $result;
    }
}
