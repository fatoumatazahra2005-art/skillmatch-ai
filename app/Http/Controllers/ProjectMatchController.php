<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Services\ProjectMatchingService;
use Illuminate\Http\Request;

class ProjectMatchController extends Controller
{
    public function __construct(
        private ProjectMatchingService $projectMatchingService
    ) {
    }

    public function match(Profile $profile, Project $project)
    {
        return $this->projectMatchingService->calculate(
            $profile,
            $project
        );
    }

    public function getByProfile(Profile $profile, Request $request)
    {
        return $this->projectMatchingService->getByProfile(
            $profile,
            $request
        );
    }
}
