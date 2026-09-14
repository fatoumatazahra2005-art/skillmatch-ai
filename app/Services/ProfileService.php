<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileService
{
    public function createOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'bio' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'education' => 'nullable|string|max:255',
            'github_url' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'availability' => 'nullable|boolean',
        ]);

        $profile = Profile::updateOrCreate(
            [
                'user_id' => $request->user()->id,
            ],
            $validated
        );

        return $profile;
    }

    public function getMyProfile(Request $request)
    {
        return Profile::with('skills')
            ->where('user_id', $request->user()->id)
            ->first();
    }

}
