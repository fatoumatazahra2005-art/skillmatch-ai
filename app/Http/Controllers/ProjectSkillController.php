<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\ProjectSkillService;
use Illuminate\Http\Request;

class ProjectSkillController extends Controller
{
    public function __construct(
        private ProjectSkillService $projectSkillService
    ) {
    }

    public function addSkill(Project $project, Request $request)
    {
        return $this->projectSkillService->addSkill(
            $project,
            $request
        );
    }
}
