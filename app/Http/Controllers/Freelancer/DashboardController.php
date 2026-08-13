<?php
namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Job;
use App\Models\Milestone;
use App\Models\Review;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();


        $stats = [
            'bids_sent'       => Bid::where('freelancer_id', $userId)->count(),
            'bids_pending'    => Bid::where('freelancer_id', $userId)->where('status','pending')->count(),
            'active_projects' => Job::where('hired_freelancer_id', $userId)->where('status','in_progress')->count(),
            'completed'       => Job::where('hired_freelancer_id', $userId)->where('status','completed')->count(),
            'total_earned'    => Milestone::whereHas('job', fn($q) => $q->where('hired_freelancer_id', $userId))
                                    ->where('payment_released', true)->sum('amount'),
            'pending_payment' => Milestone::whereHas('job', fn($q) => $q->where('hired_freelancer_id', $userId))
                                    ->whereIn('status', ['pending','in_progress','submitted','revision'])
                                    ->sum('amount'),
            'avg_rating'      => Review::where('reviewee_id', $userId)->avg('rating') ?? 0,
            'total_reviews'   => Review::where('reviewee_id', $userId)->count(),
        ];


        $recentBids = Bid::where('freelancer_id', $userId)
            ->with('job.category')
            ->latest()
            ->take(5)
            ->get();


        $activeProjects = Job::where('hired_freelancer_id', $userId)
            ->where('status', 'in_progress')
            ->with('client', 'milestones')
            ->latest()
            ->take(3)
            ->get();


        $availableJobs = Job::where('status', 'open')
            ->with('category', 'client')
            ->latest()
            ->take(5)
            ->get();


        $earnings = Milestone::whereHas('job', fn($q) => $q->where('hired_freelancer_id', $userId))
            ->where('payment_released', true)
            ->selectRaw('MONTH(payment_released_at) as month, YEAR(payment_released_at) as year, SUM(amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->take(6)
            ->get();

        return view('freelancer.dashboard', compact(
            'stats', 'recentBids', 'activeProjects', 'availableJobs', 'earnings'
        ));
    }
}