<?php

namespace App\Http\Controllers;

use App\Services\OpportunityService;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function __construct(
        private OpportunityService $opportunityService
    ) {
    }

    public function create(Request $request)
    {
        return $this->opportunityService->create($request);
    }

    public function getAll()
    {
        return $this->opportunityService->getAll();
    }
}
