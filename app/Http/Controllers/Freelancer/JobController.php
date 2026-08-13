<?php
namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        $query = Job::where('status', 'open')
            ->with('client', 'category')
            ->latest();


        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }


        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }


        if ($request->filled('budget_type')) {
            $query->where('budget_type', $request->budget_type);
        }


        if ($request->filled('budget_min')) {
            $query->where('budget_min', '>=', $request->budget_min);
        }


        if ($request->filled('budget_max')) {
            $query->where('budget_min', '<=', $request->budget_max);
        }


        if ($request->filled('experience')) {
            $query->where('experience_level', $request->experience);
        }


        if ($request->filled('project_length')) {
            $query->where('project_length', $request->project_length);
        }


        if ($request->filled('skill')) {
            $query->whereJsonContains('required_skills', $request->skill);
        }


        match($request->sort ?? 'latest') {
            'oldest'     => $query->oldest(),
            'budget_asc' => $query->orderBy('budget_min', 'asc'),
            'budget_desc'=> $query->orderBy('budget_min', 'desc'),
            'bids_asc'   => $query->orderBy('bids_count', 'asc'),
            default      => $query->latest(),
        };

        $jobs       = $query->paginate(10)->withQueryString();
        $categories = Category::where('is_active', true)->get();


        $totalResults = $query->toBase()->getCountForPagination();

        return view('freelancer.jobs.index', compact('jobs', 'categories', 'totalResults'));
    }

    public function show(Job $job): View
    {
        abort_if(!$job->isOpen(), 404);
        $job->load('client', 'category');
        $hasAlreadyBid = $job->hasUserBid(auth()->id());
        return view('freelancer.jobs.show', compact('job', 'hasAlreadyBid'));
    }
}