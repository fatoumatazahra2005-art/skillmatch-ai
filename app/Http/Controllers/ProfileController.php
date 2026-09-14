<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        private ProfileService $profileService
    ) {
    }

    public function createOrUpdate(Request $request)
    {
        return $this->profileService->createOrUpdate($request);
    }
}
