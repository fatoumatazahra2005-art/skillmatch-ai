<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectRequest;
use App\Services\ProjectRequestService;
use Illuminate\Http\Request;

class ProjectRequestController extends Controller
{
    public function __construct(
        private ProjectRequestService $projectRequestService
    ) {}

    public function joinProject(Project $project, Request $request)
    {
        return $this->projectRequestService->joinProject(
            $project,
            $request
        );
    }

    public function getRequests(Project $project, Request $request)
    {
        return $this->projectRequestService->getRequests(
            $project,
            $request
        );
    }

    public function acceptRequest(ProjectRequest $projectRequest, Request $request)
    {
        return $this->projectRequestService->acceptRequest(
            $projectRequest,
            $request
        );
    }

    public function rejectRequest(ProjectRequest $projectRequest, Request $request)
    {
        return $this->projectRequestService->rejectRequest(
            $projectRequest,
            $request
        );
    }
}
