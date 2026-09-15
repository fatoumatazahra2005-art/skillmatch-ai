<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\Project;

class TeamMatchingService
{
    public function getProjectSkills(Project $project)
    {
        return $project->skills;
    }

    public function getProfiles()
    {
        return Profile::with('skills')->get();
    }

    public function getMatchedSkills($projectSkills, $profile)
    {
        return $projectSkills->filter(function ($projectSkill) use ($profile) {
            return $profile->skills->contains('id', $projectSkill->id);
        });
    }

    public function calculateScore($projectSkills, $matchedSkills)
    {
        if ($projectSkills->count() === 0) {
            return 0;
        }

        return round(
            ($matchedSkills->count() / $projectSkills->count()) * 100,
            2
        );
    }

    public function getMissingSkills($projectSkills, $matchedSkills)
    {
        return $projectSkills->diff($matchedSkills);
    }

    public function matchProject(Project $project)
    {
        $projectSkills = $this->getProjectSkills($project);
        $profiles = $this->getProfiles();

        $matches = [];

        foreach ($profiles as $profile) {
            $matchedSkills = $this->getMatchedSkills(
                $projectSkills,
                $profile
            );

            $missingSkills = $this->getMissingSkills(
                $projectSkills,
                $matchedSkills
            );

            $score = $this->calculateScore(
                $projectSkills,
                $matchedSkills
            );

            if ($score === 0) {
                continue;
            }

            $matches[] = [
                'profile' => $profile,
                'score' => $score,
                'matched_skills' => $matchedSkills,
                'missing_skills' => $missingSkills,
            ];
        }

        usort($matches, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return collect($matches)
            ->map(fn ($match) => $this->formatMatch($match))
            ->values()
            ->all();
    }

    public function formatMatch($match)
    {
        return [
            'profile_id' => $match['profile']->id,
            'user_id' => $match['profile']->user_id,
            'score' => $match['score'],
            'matched_skills' => $match['matched_skills']->pluck('name')->values(),
            'missing_skills' => $match['missing_skills']->pluck('name')->values(),
        ];
    }

}
