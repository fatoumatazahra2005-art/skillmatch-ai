<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectService
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'is_open' => 'nullable|boolean',
        ]);

        return Project::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);
    }

    public function getAll()
    {
        return Project::with('user')->get();
    }

    public function getById(Project $project)
    {
        return $project->load('user', 'skills');
    }

}
