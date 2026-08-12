<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        $query = Job::with('client', 'category')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $jobs = $query->paginate(15)->withQueryString();

        return view('admin.jobs.index', compact('jobs'));
    }

    public function destroy(Job $job): RedirectResponse
    {
        $job->delete();

        return back()->with('success', 'Job deleted successfully.');
    }
}