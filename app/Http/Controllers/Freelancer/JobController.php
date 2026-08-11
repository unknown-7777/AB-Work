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
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }


        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }


        if ($request->filled('budget_type')) {
            $query->where('budget_type', $request->budget_type);
        }

        $jobs       = $query->paginate(10)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('freelancer.jobs.index', compact('jobs', 'categories'));
    }


    public function show(Job $job): View
    {
        abort_if(!$job->isOpen(), 404);

        $job->load('client', 'category');
        $hasAlreadyBid = $job->hasUserBid(auth()->id());

        return view('freelancer.jobs.show', compact('job', 'hasAlreadyBid'));
    }
}