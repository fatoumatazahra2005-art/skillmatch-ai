<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opportunity;
use App\Models\Profile;
use App\Services\JobMatchingService;

class JobMatchController extends Controller
{
    public function __construct(
        private JobMatchingService $jobMatchingService
    ) {
    }

    public function match(Profile $profile, Opportunity $opportunity)
    {
        return $this->jobMatchingService->calculate(
            $profile,
            $opportunity
        );
    }
    public function getByProfile(Profile $profile, Request $request)
    {
        return $this->jobMatchingService->getByProfile(
            $profile,
            $request
        );
    }

}
