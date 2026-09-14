<?php

namespace App\Services;

use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityService
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        return Opportunity::create($validated);
    }

    public function getAll()
    {
        return Opportunity::with('skills')->get();
    }

}
