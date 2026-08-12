<?php
namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Job::where('hired_freelancer_id', auth()->id())
            ->with('client', 'category', 'milestones')
            ->latest()
            ->paginate(10);

        return view('freelancer.projects.index', compact('projects'));
    }

    public function show(Job $job): View
    {
        abort_if($job->hired_freelancer_id !== auth()->id(), 403);
        $job->load('milestones', 'client');
        return view('freelancer.projects.show', compact('job'));
    }
}