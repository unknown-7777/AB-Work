<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Client\DashboardController as ClientDashboard;
use App\Http\Controllers\Freelancer\DashboardController as FreelancerDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Client routes
Route::middleware(['auth', 'verified'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboard::class, 'index'])->name('dashboard');
});

// Freelancer routes
Route::middleware(['auth', 'verified'])->prefix('freelancer')->name('freelancer.')->group(function () {
    Route::get('/dashboard', [FreelancerDashboard::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';