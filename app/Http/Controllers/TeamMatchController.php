<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\TeamMatchingService;
use Illuminate\Http\Request;

class TeamMatchController extends Controller
{
    public function __construct(
        private TeamMatchingService $teamMatchingService
    ) {}

    public function match(Project $project, Request $request)
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403, 'Vous ne pouvez pas consulter les correspondances de ce projet.');
        }

        return $this->teamMatchingService->matchProject($project);
    }
}
