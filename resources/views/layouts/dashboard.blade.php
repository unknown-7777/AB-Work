<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreelanceHub – @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">
    <style>
        body { background: #f1f5f9; font-family: 'Segoe UI', sans-serif; }


        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #1e3a8a;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            transition: all 0.3s;
        }
        .sidebar-brand {
            padding: 20px 24px;
            color: #fff;
            font-size: 1.4rem;
            font-weight: 800;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: block;
            text-decoration: none;
        }
        .sidebar-brand span { color: #fbbf24; }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 24px;
            border-radius: 0;
            transition: all 0.2s;
            font-size: 0.95rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.1);
            border-left: 3px solid #fbbf24;
        }
        .sidebar .nav-link i { margin-right: 10px; font-size: 1.1rem; }


        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }


        .topbar {
            background: #fff;
            padding: 14px 28px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .topbar .page-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #1e3a8a;
            margin: 0;
        }


        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            border: none;
        }
        .stat-card .stat-icon {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .stat-card .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1e3a8a;
        }
        .stat-card .stat-label {
            color: #64748b;
            font-size: 0.85rem;
        }


        .content-area { padding: 28px; }

        @media (max-width: 768px) {
            .sidebar { width: 100%; min-height: auto; position: relative; }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>


    <div class="sidebar">
        <a href="/" class="sidebar-brand">
            <i class="bi bi-briefcase-fill me-1"></i>AB<span>Work</span>
        </a>
        <nav class="nav flex-column mt-3">
    
            @if(auth()->user()->isClient())
                <a href="{{ route('client.dashboard') }}"
                   class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('client.jobs.create') }}"
                   class="nav-link {{ request()->routeIs('client.jobs.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i> Post a Job
                </a>
                <a href="{{ route('client.jobs.index') }}"
                   class="nav-link {{ request()->routeIs('client.jobs.index') ? 'active' : '' }}">
                    <i class="bi bi-briefcase"></i> My Jobs
                </a>
                <a href="#" class="nav-link">
                    <i class="bi bi-chat-dots"></i> Messages
                </a>
    
                @elseif(auth()->user()->isFreelancer())
                    <a href="{{ route('freelancer.dashboard') }}"
                       class="nav-link {{ request()->routeIs('freelancer.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="{{ route('freelancer.jobs.index') }}"
                       class="nav-link {{ request()->routeIs('freelancer.jobs.*') ? 'active' : '' }}">
                        <i class="bi bi-search"></i> Find Jobs
                    </a>
                    <a href="{{ route('freelancer.bids.index') }}"
                       class="nav-link {{ request()->routeIs('freelancer.bids.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text"></i> My Bids
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-chat-dots"></i> Messages
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-person-circle"></i> My Profile
                    </a>
    
            @elseif(auth()->user()->isAdmin())
                <a href="#" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="#" class="nav-link">
                    <i class="bi bi-people"></i> Users
                </a>
                <a href="#" class="nav-link">
                    <i class="bi bi-briefcase"></i> All Jobs
                </a>
            @endif
    
        </nav>
    
        <div style="position:absolute; bottom:0; width:100%; border-top:1px solid rgba(255,255,255,0.1);">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </div>


<div class="main-content">


    <div class="topbar">
        <h1 class="page-title">@yield('title')</h1>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold">
                {{ ucfirst(auth()->user()->role) }}
            </span>
            <span class="text-muted small">{{ auth()->user()->name }}</span>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff&size=36"
                 class="rounded-circle" width="36" height="36">
        </div>
    </div>


    <div class="px-4 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>


    <div class="content-area">
        @yield('content')
    </div>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
@stack('scripts')
</body>
</html>