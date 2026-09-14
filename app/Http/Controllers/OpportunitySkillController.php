<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\Services\OpportunitySkillService;
use Illuminate\Http\Request;

class OpportunitySkillController extends Controller
{
    public function __construct(
        private OpportunitySkillService $opportunitySkillService
    ) {
    }

    public function addSkill(Opportunity $opportunity, Request $request)
    {
        return $this->opportunitySkillService->addSkill(
            $opportunity,
            $request
        );
    }

}
