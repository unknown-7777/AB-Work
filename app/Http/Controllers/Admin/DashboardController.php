<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users'       => User::count(),
            'total_clients'     => User::where('role', 'client')->count(),
            'total_freelancers' => User::where('role', 'freelancer')->count(),
            'total_jobs'        => Job::count(),
            'open_jobs'         => Job::where('status', 'open')->count(),
            'in_progress_jobs'  => Job::where('status', 'in_progress')->count(),
            'completed_jobs'    => Job::where('status', 'completed')->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentJobs  = Job::with('client', 'category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentJobs'));
    }
}