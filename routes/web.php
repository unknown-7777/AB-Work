<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\FreelancerDirectoryController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\JobController as AdminJobController;

use App\Http\Controllers\Client\DashboardController as ClientDashboard;
use App\Http\Controllers\Client\JobController as ClientJobController;
use App\Http\Controllers\Client\BidController as ClientBidController;
use App\Http\Controllers\Client\MilestoneController as ClientMilestoneController;

use App\Http\Controllers\Freelancer\MilestoneController as FreelancerMilestoneController;
use App\Http\Controllers\Freelancer\DashboardController as FreelancerDashboard;
use App\Http\Controllers\Freelancer\JobController as FreelancerJobController;
use App\Http\Controllers\Freelancer\BidController;
use App\Http\Controllers\Freelancer\ProjectController;
use App\Http\Controllers\Freelancer\ProfileController as FreelancerProfileController;

Route::get('/', function () {

    if (Auth::check()) {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
                
            case 'client':
                return redirect()->route('client.dashboard'); 
                
            case 'freelancer':
                return redirect()->route('freelancer.dashboard'); 
                
            default:

                return redirect()->route('dashboard'); 
        }
    }

    return redirect()->route('login');
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
        Route::get('/projects',                         [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{job}',                   [ProjectController::class, 'show'])->name('projects.show');
        Route::get('/profile',                          [FreelancerProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile',                         [FreelancerProfileController::class, 'update'])->name('profile.update');
    });

    // Admin routes
    Route::middleware(['auth', 'verified', 'role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard',                    [AdminDashboard::class, 'index'])->name('dashboard');
            Route::get('/users',                        [AdminUserController::class, 'index'])->name('users.index');
            Route::patch('/users/{user}/toggle',        [AdminUserController::class, 'toggle'])->name('users.toggle');
            Route::delete('/users/{user}',              [AdminUserController::class, 'destroy'])->name('users.destroy');
            Route::get('/jobs',                         [AdminJobController::class, 'index'])->name('jobs.index');
            Route::delete('/jobs/{job}',                [AdminJobController::class, 'destroy'])->name('jobs.destroy');
        });

        Route::middleware('auth')->group(function () {
            Route::get('/profile',                      [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile',                    [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile',                   [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::get('/jobs/{job}/review',            [ReviewController::class, 'create'])->name('reviews.create');
            Route::post('/jobs/{job}/review',           [ReviewController::class, 'store'])->name('reviews.store');
            Route::get('/messages',                     [MessageController::class, 'index'])->name('messages.index');
            Route::get('/messages/{user}',              [MessageController::class, 'show'])->name('messages.show');
            Route::post('/messages/{user}',             [MessageController::class, 'store'])->name('messages.store');
            Route::post('/avatar',                      [AvatarController::class, 'update'])->name('avatar.update');
            Route::delete('/avatar',                    [AvatarController::class, 'destroy'])->name('avatar.destroy');
            Route::get('/freelancers',                  [FreelancerDirectoryController::class, 'index'])->name('freelancers.index');
            Route::get('/freelancers/{user}',           [FreelancerDirectoryController::class, 'show'])->name('freelancers.show');
            // Route::get('/freelancers-profile/{userId}', [FreelancerProfileController::class, 'show'])->name('freelancer.profile.show')->middleware('auth');
        });
        
        Route::get('/lang/{locale}', function ($locale) {
            if (in_array($locale, ['en', 'ru', 'tm'])) {
                session(['locale' => $locale]);
            }
            return back();
            })->name('lang.switch');

require __DIR__.'/auth.php';