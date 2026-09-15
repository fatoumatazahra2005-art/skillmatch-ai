<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Services\ProjectMemberService;

class ProjectMemberController extends Controller
{
    public function __construct(
        private ProjectMemberService $projectMemberService
    ) {}

    public function addMember(Project $project, Request $request)
    {
        return $this->projectMemberService->addMember(
            $project,
            $request
        );
    }
}
