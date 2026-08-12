<?php
namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $profile = auth()->user()->profile
            ?? new Profile(['user_id' => auth()->id()]);

        return view('freelancer.profile.edit', compact('profile'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'title'        => ['nullable', 'string', 'max:100'],
            'bio'          => ['nullable', 'string', 'max:1000'],
            'location'     => ['nullable', 'string', 'max:100'],
            'website'      => ['nullable', 'url'],
            'hourly_rate'  => ['nullable', 'numeric', 'min:1'],
            'skills'       => ['nullable', 'string'],
            'availability' => ['required', 'in:available,busy,unavailable'],
        ]);


        $skills = null;
        if ($request->filled('skills')) {
            $skills = array_map('trim', explode(',', $request->skills));
        }


        Profile::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'title'        => $request->title,
                'bio'          => $request->bio,
                'location'     => $request->location,
                'website'      => $request->website,
                'hourly_rate'  => $request->hourly_rate,
                'skills'       => $skills,
                'availability' => $request->availability,
            ]
        );

        return back()->with('success', 'Profile updated successfully!');
    }


    public function show(int $userId): View
    {
        $user = \App\Models\User::with(['profile', 'reviewsReceived.reviewer'])
            ->where('role', 'freelancer')
            ->findOrFail($userId);

        return view('freelancer.profile.show', compact('user'));
    }
}