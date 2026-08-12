<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $stats = [
            'active_jobs'    => Job::where('client_id', $userId)->where('status', 'open')->count(),
            'total_bids'     => Job::where('client_id', $userId)->withCount('bids')->get()->sum('bids_count'),
            'in_progress'    => Job::where('client_id', $userId)->where('status', 'in_progress')->count(),
            'completed'      => Job::where('client_id', $userId)->where('status', 'completed')->count(),
        ];

        $recentJobs = Job::where('client_id', $userId)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('client.dashboard', compact('stats', 'recentJobs'));
    }
}