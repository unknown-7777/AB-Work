<?php
namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Job;
use App\Models\Milestone;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $stats = [
            'bids_sent'      => Bid::where('freelancer_id', $userId)->count(),
            'active_projects'=> Job::where('hired_freelancer_id', $userId)->where('status', 'in_progress')->count(),
            'completed'      => Job::where('hired_freelancer_id', $userId)->where('status', 'completed')->count(),
            'total_earned'   => Milestone::whereHas('job', fn($q) => $q->where('hired_freelancer_id', $userId))
                                    ->where('payment_released', true)
                                    ->sum('amount'),
        ];

        $recentBids = Bid::where('freelancer_id', $userId)
            ->with('job.category')
            ->latest()
            ->take(5)
            ->get();

        $availableJobs = Job::where('status', 'open')
            ->with('category', 'client')
            ->latest()
            ->take(5)
            ->get();

        return view('freelancer.dashboard', compact('stats', 'recentBids', 'availableJobs'));
    }
}