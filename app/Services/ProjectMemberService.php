<?php

namespace App\Services;
use App\Models\Project;
use App\Models\ProjectMember;
use Illuminate\Http\Request;

class ProjectMemberService
{
    public function addMember(Project $project, Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|string|max:255',
        ]);

        if ($project->user_id !== $request->user()->id) {
            abort(403, 'Vous ne pouvez pas ajouter de membre à ce projet.');
        }

        $existingMember = ProjectMember::where('project_id', $project->id)
            ->where('user_id', $validated['user_id'])
            ->first();

        if ($existingMember) {
            abort(409, 'Cet utilisateur est déjà membre de ce projet.');
        }

        $member = ProjectMember::create([
            'project_id' => $project->id,
            'user_id' => $validated['user_id'],
            'role' => $validated['role'] ?? null,
            'joined_at' => now(),
        ]);

        return $member->load('user');
    }
    public function getMembers(Project $project, Request $request)
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403, 'Vous ne pouvez pas consulter les membres de ce projet.');
        }

        return ProjectMember::with('user')
            ->where('project_id', $project->id)
            ->get();
    }

    public function removeMember(ProjectMember $member, Request $request)
    {
        if ($member->project->user_id !== $request->user()->id) {
            abort(403, 'Vous ne pouvez pas retirer ce membre.');
        }

        $member->delete();

        return response()->json([
            'message' => 'Membre retiré du projet avec succès.'
        ]);
    }

}
