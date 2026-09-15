<?php

namespace App\Services;

use Gemini;

class AIService
{

    public function analyzeJobMatch(array $profileSkills, array $opportunitySkills)
    {
        $client = Gemini::client(
            config('services.gemini.key')
        );

        $prompt = "
You are an AI assistant specialized in IT recruitment.

Analyze the compatibility between a candidate's profile and a job opportunity.

Candidate's skills:
" . implode(', ', $profileSkills) . "

Required skills:
" . implode(', ', $opportunitySkills) . "

The score, matched skills, and missing skills have already been calculated by Laravel.

Your only task is to generate a clear, concise, and helpful explanation in French.

Do not calculate the score.
Do not return matched_skills.
Do not return missing_skills.

Return ONLY valid JSON, without markdown and without any text before or after the JSON.

Use exactly this structure:

{
  \"explanation\": \"\"
}

The explanation should:
- Be written in French.
- Clearly explain why the candidate is a good or partial match.
- Mention relevant strengths when appropriate.
- Mention missing skills when relevant.
- Remain concise and professional.
";

        $result = $client
            ->generativeModel(model: 'gemini-3.6-flash')
            ->generateContent($prompt);

        return json_decode($result->text(), true);
    }

    public function analyzeProjectMatch(array $profileSkills, array $projectSkills)
    {
        $prompt = "
You are an AI assistant specialized in developer team formation.

Analyze the compatibility between a developer's profile and a project.

Developer's skills:
" . implode(', ', $profileSkills) . "

Project's required skills:
" . implode(', ', $projectSkills) . "

The score, matched skills, and missing skills have already been calculated by Laravel.

Your only task is to generate a clear, concise, and helpful explanation in French.

Do not calculate the score.
Do not return matched_skills.
Do not return missing_skills.

Return ONLY valid JSON, without markdown and without any text before or after the JSON.

Use exactly this structure:

{
  \"explanation\": \"\"
}

The explanation should:
- Be written in French.
- Explain how the developer can contribute to the project.
- Mention relevant skills when appropriate.
- Mention missing skills when relevant.
- Remain concise and professional.
";

        $client = Gemini::client(
            config('services.gemini.key')
        );

        $result = $client
            ->generativeModel(model: 'gemini-3.6-flash')
            ->generateContent($prompt);
        return json_decode($result->text(), true);
    }
}
