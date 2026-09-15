<?php

namespace App\Services;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectRequest;
use Illuminate\Http\Request;

class ProjectRequestService
{
    public function joinProject(Project $project, Request $request)
    {
        if ($project->user_id === $request->user()->id) {
            abort(403, 'Vous êtes déjà propriétaire de ce projet.');
        }
        if (!$project->is_open) {
            abort(403, 'Ce projet n’accepte plus de demandes.');
        }

        $existingMember = ProjectMember::where('project_id', $project->id)
            ->where('user_id', $request->user()->id)
            ->first();

        if ($existingMember) {
            abort(409, 'Vous êtes déjà membre de ce projet.');
        }

        $existingRequest = ProjectRequest::where('project_id', $project->id)
            ->where('user_id', $request->user()->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            abort(409, 'Vous avez déjà une demande en attente pour ce projet.');
        }

        $projectRequest = ProjectRequest::create([
            'project_id' => $project->id,
            'user_id' => $request->user()->id,
            'status' => 'pending',
        ]);

        return $projectRequest->load('user');
    }

    public function getRequests(Project $project, Request $request)
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403, 'Vous ne pouvez pas consulter les demandes de ce projet.');
        }
        return ProjectRequest::with('user')
            ->where('project_id', $project->id)
            ->where('status', 'pending')
            ->get();
    }

    public function acceptRequest(ProjectRequest $projectRequest, Request $request)
    {
        if ($projectRequest->project->user_id !== $request->user()->id) {
            abort(403, 'Vous ne pouvez pas accepter cette demande.');
        }
        if ($projectRequest->status !== 'pending') {
            abort(409, 'Cette demande a déjà été traitée.');
        }
        $member = ProjectMember::create([
            'project_id' => $projectRequest->project_id,
            'user_id' => $projectRequest->user_id,
            'role' => null,
            'joined_at' => now(),
        ]);

        $projectRequest->update([
            'status' => 'accepted',
        ]);

        return $member->load('user');
    }

    public function rejectRequest(ProjectRequest $projectRequest, Request $request)
    {
        if ($projectRequest->project->user_id !== $request->user()->id) {
            abort(403, 'Vous ne pouvez pas refuser cette demande.');
        }
        if ($projectRequest->status !== 'pending') {
            abort(409, 'Cette demande a déjà été traitée.');
        }
        $projectRequest->update([
            'status' => 'rejected',
        ]);
        return $projectRequest->load('user');
    }

}
