<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Services\ProfileSkillService;
use Illuminate\Http\Request;

class ProfileSkillController extends Controller
{
    public function __construct(
        private ProfileSkillService $profileSkillService
    ) {
    }

    public function addSkill(Profile $profile, Request $request)
    {
        return $this->profileSkillService->addSkill(
            $profile,
            $request
        );
    }
}
