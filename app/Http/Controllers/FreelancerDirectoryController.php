<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FreelancerDirectoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'freelancer')
            ->where('is_active', true)
            ->with('profile', 'reviewsReceived')
            ->latest();


        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhereHas('profile', function ($q) use ($request) {
                      $q->where('title', 'like', '%'.$request->search.'%')
                        ->orWhere('bio', 'like', '%'.$request->search.'%');
                  });
            });
        }


        if ($request->filled('skill')) {
            $query->whereHas('profile', function ($q) use ($request) {
                $q->whereJsonContains('skills', $request->skill);
            });
        }


        if ($request->filled('availability')) {
            $query->whereHas('profile', function ($q) use ($request) {
                $q->where('availability', $request->availability);
            });
        }


        if ($request->filled('max_rate')) {
            $query->whereHas('profile', function ($q) use ($request) {
                $q->where('hourly_rate', '<=', $request->max_rate);
            });
        }


        match($request->sort ?? 'latest') {
            'rating'   => $query->whereHas('profile')->orderByDesc(
                              \App\Models\Profile::select('avg_rating')
                                  ->whereColumn('user_id', 'users.id')
                                  ->limit(1)
                          ),
            'rate_asc' => $query->whereHas('profile')->orderByDesc(
                              \App\Models\Profile::select('hourly_rate')
                                  ->whereColumn('user_id', 'users.id')
                                  ->limit(1)
                          ),
            default    => $query->latest(),
        };

        $freelancers = $query->paginate(12)->withQueryString();


        $allSkills = \App\Models\Profile::whereNotNull('skills')
            ->pluck('skills')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return view('freelancers.index', compact('freelancers', 'allSkills'));
    }

    public function show(User $user): View
    {
        abort_if(!$user->isFreelancer(), 404);
        abort_if(!$user->is_active, 404);

        $user->load('profile', 'reviewsReceived.reviewer');

        $completedJobs = \App\Models\Job::where('hired_freelancer_id', $user->id)
            ->where('status', 'completed')
            ->count();

        return view('freelancers.show', compact('user', 'completedJobs'));
    }
}