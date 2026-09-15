<?php

namespace App\Http\Controllers;

use App\Models\ProjectMember;
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

    public function getMembers(Project $project, Request $request)
    {
        return $this->projectMemberService->getMembers(
            $project,
            $request
        );
    }

    public function removeMember(ProjectMember $member, Request $request)
    {
        return $this->projectMemberService->removeMember(
            $member,
            $request
        );
    }
}
