<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Client\DashboardController as ClientDashboard;
use App\Http\Controllers\Client\JobController as ClientJobController;
use App\Http\Controllers\Client\BidController as ClientBidController;
use App\Http\Controllers\Client\MilestoneController as ClientMilestoneController;
use App\Http\Controllers\Freelancer\MilestoneController as FreelancerMilestoneController;
use App\Http\Controllers\Freelancer\DashboardController as FreelancerDashboard;
use App\Http\Controllers\Freelancer\JobController as FreelancerJobController;
use App\Http\Controllers\Freelancer\BidController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Client routes
Route::middleware(['auth', 'verified', 'role:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {
        Route::get('/dashboard',                        [ClientDashboard::class, 'index'])->name('dashboard');
        Route::get('/jobs',                             [ClientJobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/create',                      [ClientJobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs',                            [ClientJobController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}',                       [ClientJobController::class, 'show'])->name('jobs.show');
        Route::patch('/bids/{bid}/accept',              [ClientBidController::class, 'accept'])->name('bids.accept');
        Route::patch('/bids/{bid}/reject',              [ClientBidController::class, 'reject'])->name('bids.reject');
        Route::get('/jobs/{job}/milestones/create',     [ClientMilestoneController::class, 'create'])->name('milestones.create');
        Route::post('/jobs/{job}/milestones',           [ClientMilestoneController::class, 'store'])->name('milestones.store');
        Route::patch('/milestones/{milestone}/approve', [ClientMilestoneController::class, 'approve'])->name('milestones.approve');
        Route::patch('/milestones/{milestone}/revision',[ClientMilestoneController::class, 'revision'])->name('milestones.revision');
    });

// Freelancer routes
Route::middleware(['auth', 'verified', 'role:freelancer'])
    ->prefix('freelancer')
    ->name('freelancer.')
    ->group(function () {
        Route::get('/dashboard',                        [FreelancerDashboard::class, 'index'])->name('dashboard');
        Route::get('/jobs',                             [FreelancerJobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/{job}',                       [FreelancerJobController::class, 'show'])->name('jobs.show');
        Route::get('/jobs/{job}/bid',                   [BidController::class, 'create'])->name('bids.create');
        Route::post('/jobs/{job}/bid',                  [BidController::class, 'store'])->name('bids.store');
        Route::get('/bids',                             [BidController::class, 'index'])->name('bids.index');
        Route::delete('/bids/{bid}',                    [BidController::class, 'destroy'])->name('bids.destroy');
        Route::patch('/milestones/{milestone}/submit',  [FreelancerMilestoneController::class, 'submit'])->name('milestones.submit');
        Route::get('/projects/{job}',                   [FreelancerMilestoneController::class, 'show'])->name('projects.show');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';