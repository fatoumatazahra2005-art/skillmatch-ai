<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectService $projectService
    ) {
    }

    public function create(Request $request)
    {
        return $this->projectService->create($request);
    }

    public function getAll()
    {
        return $this->projectService->getAll();
    }

    public function getById(Project $project)
    {
        return $this->projectService->getById($project);
    }
}
