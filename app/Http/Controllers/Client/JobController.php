<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Models\Category;
use App\Models\Job;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JobController extends Controller
{

    public function create(): View
    {
        $categories = Category::where('is_active', true)->get();
        return view('client.jobs.create', compact('categories'));
    }


    public function store(StoreJobRequest $request): RedirectResponse
    {

        $skills = null;
        if ($request->required_skills) {
            $skills = array_map('trim', explode(',', $request->required_skills));
        }

        Job::create([
            ...$request->validated(),
            'client_id'       => auth()->id(),
            'required_skills' => $skills,
            'status'          => 'open',
        ]);

        return redirect()
            ->route('client.jobs.index')
            ->with('success', 'Job posted successfully!');
    }


    public function index(): View
    {
        $jobs = Job::where('client_id', auth()->id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('client.jobs.index', compact('jobs'));
    }


    public function show(Job $job): View
    {
        abort_if($job->client_id !== auth()->id(), 403);

        $job->load('bids.freelancer.profile', 'category');

        return view('client.jobs.show', compact('job'));
    }
}