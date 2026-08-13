<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} – Find Work. Hire Talent.</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">
    <style>
        body { font-family: 'Segoe UI', sans-serif; }
        .navbar { background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .navbar-brand { font-weight: 800; font-size: 1.5rem; color: #2563eb !important; }
        .hero {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #0ea5e9 100%);
            min-height: 88vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero::after {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(255,255,255,0.08), transparent 70%);
            bottom: -100px; right: -100px;
            border-radius: 50%;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 50px;
            padding: 6px 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .hero h1 { font-size: clamp(2.2rem, 5vw, 3.8rem); font-weight: 800; color: #fff; line-height: 1.15; }
        .hero h1 span { background: linear-gradient(135deg, #fbbf24, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero p { color: rgba(255,255,255,0.8); font-size: 1.15rem; }
        .btn-hero { background: #fff; color: #2563eb; font-weight: 700; border-radius: 10px; padding: 12px 30px; text-decoration: none; transition: all 0.2s; display: inline-block; }
        .btn-hero:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.2); color: #2563eb; }
        .btn-hero-outline { background: transparent; color: #fff; border: 2px solid rgba(255,255,255,0.5); font-weight: 600; border-radius: 10px; padding: 12px 30px; text-decoration: none; transition: all 0.2s; display: inline-block; }
        .btn-hero-outline:hover { border-color: #fff; color: #fff; background: rgba(255,255,255,0.1); }
        .stats-bar { background: #1e3a8a; padding: 28px 0; }
        .stat-number { font-size: 1.9rem; font-weight: 800; color: #fbbf24; }
        .stat-label { color: rgba(255,255,255,0.7); font-size: 0.85rem; }
        .category-card { border: 1px solid #e5e7eb; border-radius: 14px; padding: 24px 16px; text-align: center; transition: all 0.25s; cursor: pointer; text-decoration: none; display: block; color: inherit; }
        .category-card:hover { border-color: #2563eb; box-shadow: 0 6px 20px rgba(37,99,235,0.12); transform: translateY(-4px); color: #2563eb; }
        .category-icon { font-size: 2rem; margin-bottom: 10px; display: block; }
        .how-section { background: #f8faff; padding: 90px 0; }
        .step-circle { width: 56px; height: 56px; background: #2563eb; border-radius: 50%; color: #fff; font-weight: 800; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        .cta-section { background: linear-gradient(135deg, #1e3a8a, #2563eb); padding: 90px 0; text-align: center; }
        footer { background: #0f172a; color: rgba(255,255,255,0.5); padding: 24px; text-align: center; font-size: 0.9rem; }
        footer span { color: #2563eb; font-weight: 700; }

        /* Logged-in dashboard styles */
        .welcome-hero {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            padding: 60px 0;
            color: #fff;
        }
        .quick-stat {
            background: rgba(255,255,255,0.1);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .quick-stat .number { font-size: 2rem; font-weight: 800; color: #fbbf24; }
        .quick-stat .label { font-size: 0.85rem; color: rgba(255,255,255,0.8); }
        .action-card {
            border: none;
            border-radius: 16px;
            padding: 28px;
            text-align: center;
            transition: all 0.3s;
            text-decoration: none;
            display: block;
            color: inherit;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
        }
        .action-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.12); color: inherit; }
        .action-icon { width: 64px; height: 64px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 16px; }
        @keyframes ab-ping { 75%, 100% { transform: scale(2.5); opacity: 0; } }
    </style>
</head>
<body>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- NAVBAR --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<nav class="navbar navbar-expand-lg sticky-top px-4 px-md-5">
    <a class="navbar-brand" href="/">
        <i class="bi bi-briefcase-fill me-1"></i>{{ config('app.name') }}
    </a>
    <div class="ms-auto d-flex align-items-center gap-2">
        @auth

        @if(auth()->user()->isClient())
                       <a href="{{ route('client.dashboard') }}" class="btn btn-primary btn-sm rounded-3">Dashboard</a>
                   @elseif(auth()->user()->isFreelancer())
                       <a href="{{ route('freelancer.dashboard') }}" class="btn btn-primary btn-sm rounded-3">Dashboard</a>
                   @else
                       <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-sm rounded-3">Admin Panel</a>
                   @endif
        
            <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-3 py-2">
                {{ ucfirst(auth()->user()->role) }}
            </span>
            <span class="fw-semibold small">{{ auth()->user()->name }}</span>

            <div class="dropdown">
                <a href="#" class="d-block link-dark text-decoration-none" id="logoutDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle text-primary" style="font-size: 36px; line-height: 1; cursor: pointer;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border border-light mt-2 p-1 rounded-3" aria-labelledby="logoutDropdown" style="min-width: 160px;">

                    <li>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item d-flex align-items-center gap-2 py-2 text-secondary">
                            <i class="bi bi-pencil-square"></i> Edit Profile
                        </a>
                    </li>
                    

                    <li><hr class="dropdown-divider my-1"></li>
                    

                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="m-0" onsubmit="return confirm('Are you sure you want to log out?');">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2 w-100">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-3">Login</a>
            <a href="{{ route('register') }}" class="btn btn-primary rounded-3">Get Started</a>
        @endauth
    </div>
</nav>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- LOGGED IN VIEW --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@auth
@php
    $user = auth()->user();
@endphp

{{-- Welcome Hero --}}
<section class="welcome-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <i class="bi bi-person-circle text-primary" style="font-size: 36px; line-height: 1;"></i>
                    <div>
                        <h2 class="fw-bold mb-0">Welcome back, {{ $user->name }}! 👋</h2>
                        <p class="mb-0 opacity-75">
                            @if($user->isClient()) Client Account
                            @elseif($user->isFreelancer()) Freelancer Account
                            @else Administrator
                            @endif
                            · Member since {{ $user->created_at->format('M Y') }}
                        </p>
                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="row g-3">
                    @if($user->isClient())
                        @php
                            $activeJobs = \App\Models\Job::where('client_id', $user->id)->where('status','open')->count();
                            $inProgress = \App\Models\Job::where('client_id', $user->id)->where('status','in_progress')->count();
                            $completed  = \App\Models\Job::where('client_id', $user->id)->where('status','completed')->count();
                        @endphp
                        <div class="col-4">
                            <div class="quick-stat">
                                <div class="number">{{ $activeJobs }}</div>
                                <div class="label">Active Jobs</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="quick-stat">
                                <div class="number">{{ $inProgress }}</div>
                                <div class="label">In Progress</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="quick-stat">
                                <div class="number">{{ $completed }}</div>
                                <div class="label">Completed</div>
                            </div>
                        </div>
                    @elseif($user->isFreelancer())
                        @php
                            $bidsSent    = \App\Models\Bid::where('freelancer_id', $user->id)->count();
                            $activeProj  = \App\Models\Job::where('hired_freelancer_id', $user->id)->where('status','in_progress')->count();
                            $earned      = \App\Models\Milestone::whereHas('job', fn($q) => $q->where('hired_freelancer_id', $user->id))->where('payment_released', true)->sum('amount');
                        @endphp
                        <div class="col-4">
                            <div class="quick-stat">
                                <div class="number">{{ $bidsSent }}</div>
                                <div class="label">Bids Sent</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="quick-stat">
                                <div class="number">{{ $activeProj }}</div>
                                <div class="label">Active Projects</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="quick-stat">
                                <div class="number">${{ number_format($earned) }}</div>
                                <div class="label">Earned</div>
                            </div>
                        </div>
                    @elseif($user->isAdmin())
                        @php
                            $totalUsers = \App\Models\User::count();
                            $totalJobs  = \App\Models\Job::count();
                            $openJobs   = \App\Models\Job::where('status','open')->count();
                        @endphp
                        <div class="col-4">
                            <div class="quick-stat">
                                <div class="number">{{ $totalUsers }}</div>
                                <div class="label">Total Users</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="quick-stat">
                                <div class="number">{{ $totalJobs }}</div>
                                <div class="label">Total Jobs</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="quick-stat">
                                <div class="number">{{ $openJobs }}</div>
                                <div class="label">Open Jobs</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Quick Actions --}}
<section class="py-5" style="background:#f8faff;">
    <div class="container">
        <h4 class="fw-bold mb-4">Quick Actions</h4>
        <div class="row g-4">
            @if($user->isClient())
                <div class="col-md-3">
                    <a href="{{ route('client.jobs.create') }}" class="action-card bg-white">
                        <div class="action-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-plus-circle"></i>
                        </div>
                        <h6 class="fw-bold">Post a Job</h6>
                        <p class="text-muted small mb-0">Find the perfect freelancer</p>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('client.jobs.index') }}" class="action-card bg-white">
                        <div class="action-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <h6 class="fw-bold">My Jobs</h6>
                        <p class="text-muted small mb-0">Manage your job posts</p>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('client.dashboard') }}" class="action-card bg-white">
                        <div class="action-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-speedometer2"></i>
                        </div>
                        <h6 class="fw-bold">Dashboard</h6>
                        <p class="text-muted small mb-0">View your overview</p>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('profile.edit') }}" class="action-card bg-white">
                        <div class="action-icon bg-info bg-opacity-10 text-info">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h6 class="fw-bold">Profile Settings</h6>
                        <p class="text-muted small mb-0">Update your info</p>
                    </a>
                </div>

            @elseif($user->isFreelancer())
                <div class="col-md-3">
                    <a href="{{ route('freelancer.jobs.index') }}" class="action-card bg-white">
                        <div class="action-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-search"></i>
                        </div>
                        <h6 class="fw-bold">Find Jobs</h6>
                        <p class="text-muted small mb-0">Browse available jobs</p>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('freelancer.bids.index') }}" class="action-card bg-white">
                        <div class="action-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <h6 class="fw-bold">My Bids</h6>
                        <p class="text-muted small mb-0">Track your proposals</p>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('freelancer.projects.index') }}" class="action-card bg-white">
                        <div class="action-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-kanban"></i>
                        </div>
                        <h6 class="fw-bold">My Projects</h6>
                        <p class="text-muted small mb-0">View active projects</p>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('freelancer.profile.edit') }}" class="action-card bg-white">
                        <div class="action-icon bg-info bg-opacity-10 text-info">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h6 class="fw-bold">My Profile</h6>
                        <p class="text-muted small mb-0">Update your profile</p>
                    </a>
                </div>

                @elseif($user->isAdmin())
                    <!-- Admin Quick Stats & Platform Overview Grid -->
                    
                    <!-- Stat Card 1: Total Users Overview -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm bg-white p-4 rounded-3 h-100 position-relative overflow-hidden">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted fw-semibold small text-uppercase tracking-wider">Total Ecosystem</span>
                                <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-2">
                                    <i class="bi bi-people-fill fs-5"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-dark mb-1">1,248</h3>
                            <p class="text-success small mb-0 fw-medium">
                                <i class="bi bi-arrow-up-short"></i> +12% this week
                            </p>
                        </div>
                    </div>
                
                    <!-- Stat Card 2: Security & Moderation Issues -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm bg-white p-4 rounded-3 h-100 position-relative overflow-hidden">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted fw-semibold small text-uppercase tracking-wider">Banned / Suspended</span>
                                <div class="p-2 bg-danger bg-opacity-10 text-danger rounded-2">
                                    <i class="bi bi-shield-slash-fill fs-5"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-dark mb-1">14</h3>
                            <p class="text-muted small mb-0">
                                Restricted platform access
                            </p>
                        </div>
                    </div>
                
                    <!-- Stat Card 3: Active Jobs Marketplace -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm bg-white p-4 rounded-3 h-100 position-relative overflow-hidden">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted fw-semibold small text-uppercase tracking-wider">Active Contracts</span>
                                <div class="p-2 bg-warning bg-opacity-10 text-warning rounded-2">
                                    <i class="bi bi-briefcase-fill fs-5"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-dark mb-1">412</h3>
                            <p class="text-success small mb-0 fw-medium">
                                <i class="bi bi-arrow-up-short"></i> +5 new today
                            </p>
                        </div>
                    </div>
                
                    <!-- Stat Card 4: NEW Action Item Queue (Replaced Settings) -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm bg-white p-4 rounded-3 h-100 position-relative overflow-hidden">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted fw-semibold small text-uppercase tracking-wider">Pending Reports</span>
                                <div class="p-2 bg-info bg-opacity-10 text-info rounded-2">
                                    <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                                </div>
                            </div>
                            <!-- Dynamic warning metric color or count -->
                            <h3 class="fw-bold text-dark mb-1">3</h3>
                            <p class="text-danger small mb-0 fw-medium">
                                <i class="bi bi-bell-fill me-1"></i> Requires attention
                            </p>
                        </div>
                    </div>
                @endif
        </div>
    </div>
</section>

{{-- Recent Activity --}}
<section class="py-5 bg-white">
    <div class="container">
        <h4 class="fw-bold mb-4">Recent Activity</h4>
        <div class="row g-4">
            @if($user->isClient())
            @php $recentJobs = \App\Models\Job::where('client_id',$user->id)->with('category')->latest()->take(3)->get(); @endphp
                @forelse($recentJobs as $job)
                <div class="col-md-4">
                    <div class="bg-light rounded-3 p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold mb-0">{{ Str::limit($job->title, 30) }}</h6>
                            <span class="badge
                                @if($job->status=='open') bg-success
                                @elseif($job->status=='in_progress') bg-primary
                                @elseif($job->status=='completed') bg-secondary
                                @else bg-danger @endif">
                                {{ ucfirst(str_replace('_',' ',$job->status)) }}
                            </span>
                        </div>
                        <small class="text-muted">{{ $job->category->name ?? 'N/A' }} · {{ $job->created_at->diffForHumans() }}</small>
                        <div class="mt-2">
                            <a href="{{ route('client.jobs.show', $job) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted py-4">
                    <i class="bi bi-briefcase fs-1 d-block mb-2 opacity-25"></i>
                    <p>No jobs yet. <a href="{{ route('client.jobs.create') }}">Post your first job!</a></p>
                </div>
                @endforelse

            @elseif($user->isFreelancer())
            @php $recentBids = \App\Models\Bid::where('freelancer_id',$user->id)->with('job')->latest()->take(3)->get(); @endphp
                @forelse($recentBids as $bid)
                @if($bid->job)
                <div class="col-md-4">
                    <div class="bg-light rounded-3 p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold mb-0">{{ Str::limit($bid->job->title, 30) }}</h6>
                            <span class="badge
                                @if($bid->status=='pending') bg-warning text-dark
                                @elseif($bid->status=='accepted') bg-success
                                @elseif($bid->status=='rejected') bg-danger
                                @else bg-secondary @endif">
                                {{ ucfirst($bid->status) }}
                            </span>
                        </div>
                        <small class="text-muted">${{ number_format($bid->amount) }} · {{ $bid->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                @endif
                @empty
                <div class="col-12 text-center text-muted py-4">
                    <i class="bi bi-search fs-1 d-block mb-2 opacity-25"></i>
                    <p>No bids yet. <a href="{{ route('freelancer.jobs.index') }}">Find jobs!</a></p>
                </div>
                @endforelse
            @endif
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- GUEST VIEW --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@else

<section class="hero">
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-badge">
                    <i class="bi bi-patch-check-fill me-1"></i> Trusted by 10,000+ professionals
                </div>
                <h1>
                    Find the perfect<br>
                    <span>Freelancer</span> for<br>
                    any job.
                </h1>
                <p class="my-4">
                    Connect with top freelancers for web development, design,
                    writing, marketing and more — or find your next client today.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('register') }}" class="btn-hero">
                        <i class="bi bi-rocket-takeoff me-2"></i>Hire a Freelancer
                    </a>
                    <a href="{{ route('register') }}" class="btn-hero-outline">
                        <i class="bi bi-person-badge me-2"></i>Find Work
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-center mt-5 mt-lg-0">
                <div class="p-4 bg-white rounded-4 shadow-lg" style="width:320px;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success rounded-circle me-2 position-relative" style="width:10px;height:10px;">
                            <span class="position-absolute top-0 start-0 w-100 h-100 bg-success rounded-circle opacity-75"
                                  style="animation: ab-ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite; display:block;"></span>
                        </div>
                        <small class="text-muted fw-semibold">Live job posted</small>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Build a Laravel REST API</h6>
                    <p class="text-muted small mb-3">Budget: $500–$1,000 · Fixed Price</p>
                    <div class="d-flex gap-2 mb-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary">Laravel</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary">PHP</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary">MySQL</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                        <small class="text-muted"><i class="bi bi-people-fill me-1 text-primary"></i>12 bids</small>
                        <span class="badge bg-success">Open</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="stats-bar">
    <div class="container">
        <div class="row g-3 text-center">
            <div class="col-6 col-md-3"><div class="stat-number">10K+</div><div class="stat-label">Freelancers</div></div>
            <div class="col-6 col-md-3"><div class="stat-number">5K+</div><div class="stat-label">Jobs Posted</div></div>
            <div class="col-6 col-md-3"><div class="stat-number">98%</div><div class="stat-label">Satisfaction Rate</div></div>
            <div class="col-6 col-md-3"><div class="stat-number">$2M+</div><div class="stat-label">Paid to Freelancers</div></div>
        </div>
    </div>
</div>

<section class="py-5 mt-3">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold fs-2">Browse by Category</h2>
            <p class="text-muted">Find the right talent across every field</p>
        </div>
        <div class="row g-3">
            @foreach([
                ['icon'=>'bi-code-slash',    'label'=>'Web Development',  'jobs'=>'1,240'],
                ['icon'=>'bi-palette',        'label'=>'Design & Creative','jobs'=>'860'],
                ['icon'=>'bi-pen',            'label'=>'Writing',         'jobs'=>'540'],
                ['icon'=>'bi-megaphone',      'label'=>'Marketing',       'jobs'=>'430'],
                ['icon'=>'bi-phone',          'label'=>'Mobile Apps',     'jobs'=>'380'],
                ['icon'=>'bi-camera-video',   'label'=>'Video & Audio',   'jobs'=>'290'],
                ['icon'=>'bi-translate',      'label'=>'Translation',     'jobs'=>'210'],
                ['icon'=>'bi-graph-up-arrow', 'label'=>'Finance',         'jobs'=>'175'],
            ] as $cat)
            <div class="col-6 col-md-3">
                <a href="{{ route('register') }}" class="category-card">
                    <i class="bi {{ $cat['icon'] }} category-icon text-primary"></i>
                    <div class="fw-bold small">{{ $cat['label'] }}</div>
                    <div class="text-muted" style="font-size:0.78rem;">{{ $cat['jobs'] }} jobs</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="how-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold fs-2">How It Works</h2>
            <p class="text-muted">Simple steps to get started</p>
        </div>
        <div class="row g-4 text-center">
            @foreach([
                ['n'=>1,'icon'=>'bi-person-plus',   'title'=>'Create Account',   'desc'=>'Sign up free as a client or freelancer in under a minute.'],
                ['n'=>2,'icon'=>'bi-file-post',     'title'=>'Post or Find Job', 'desc'=>'Clients post jobs. Freelancers browse and submit proposals.'],
                ['n'=>3,'icon'=>'bi-check2-circle', 'title'=>'Hire & Agree',     'desc'=>'Review bids, chat, and hire the best match for your project.'],
                ['n'=>4,'icon'=>'bi-stars',         'title'=>'Deliver & Review', 'desc'=>'Work gets done via milestones. Leave a review when complete.'],
            ] as $step)
            <div class="col-md-3">
                <div class="step-circle">{{ $step['n'] }}</div>
                <i class="bi {{ $step['icon'] }} fs-3 text-primary mb-2 d-block"></i>
                <h6 class="fw-bold">{{ $step['title'] }}</h6>
                <p class="text-muted small">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2 class="fw-bold text-white fs-1 mb-3">Ready to get started?</h2>
        <p class="text-white opacity-75 mb-4 fs-5">Join thousands of clients and freelancers already on {{ config('app.name') }}.</p>
        <a href="{{ route('register') }}" class="btn-hero">
            <i class="bi bi-rocket-takeoff me-2"></i>Join for Free
        </a>
    </div>
</section>

@endauth

<footer>
    <p>© {{ date('Y') }} <span>{{ config('app.name') }}</span> — Find Work. Hire Talent.</p>
</footer>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>