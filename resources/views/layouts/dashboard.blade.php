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
                   class="nav-link {{ request()->routeIs('client.jobs.index', 'client.jobs.show') ? 'active' : '' }}">
                    <i class="bi bi-briefcase"></i> My Jobs
                </a>

                @php
                    $unreadMessages = \App\Models\Message::where('receiver_id', auth()->id())
                        ->where('is_read', false)->count();
                @endphp
                
                <a href="{{ route('messages.index') }}"
                   class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-dots"></i> Messages
                    @if($unreadMessages > 0)
                        <span class="badge bg-danger ms-1">{{ $unreadMessages }}</span>
                    @endif
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

                    @php
                        $unreadMessages = \App\Models\Message::where('receiver_id', auth()->id())
                            ->where('is_read', false)->count();
                    @endphp
                    
                    <a href="{{ route('messages.index') }}"
                       class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots"></i> Messages
                        @if($unreadMessages > 0)
                            <span class="badge bg-danger ms-1">{{ $unreadMessages }}</span>
                        @endif
                    </a>

                    <a href="{{ route('freelancer.profile.edit') }}"
                       class="nav-link {{ request()->routeIs('freelancer.profile.*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i> My Profile
                    </a>
                    <a href="{{ route('freelancer.projects.index') }}"
                       class="nav-link {{ request()->routeIs('freelancer.projects.*') ? 'active' : '' }}">
                        <i class="bi bi-kanban"></i> My Projects
                    </a>
    
            @elseif(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Users
                </a>
                <a href="{{ route('admin.jobs.index') }}"
                   class="nav-link {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}">
                    <i class="bi bi-briefcase"></i> All Jobs
                </a>
            @endif
    
        </nav>
        
    </div>



<div class="main-content">


    <div class="topbar">
        <h1 class="page-title">@yield('title')</h1>
        <div class="d-flex align-items-center gap-3">
            
            
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    @if(app()->getLocale() == 'ru') 🇷🇺 RU
                    @elseif(app()->getLocale() == 'tk') 🇹🇲 TK
                    @else 🇬🇧 EN @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">🇬🇧 English</a></li>
                    <li><a class="dropdown-item" href="{{ route('lang.switch', 'ru') }}">🇷🇺 Русский</a></li>
                    <li><a class="dropdown-item" href="{{ route('lang.switch', 'tk') }}">🇹🇲 Türkmençe</a></li>
                </ul>
            </div>

            
            <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold">
                {{ ucfirst(auth()->user()->role) }}
            </span>
            
            
            <span class="text-muted small fw-medium">{{ auth()->user()->name }}</span>
            
            
            <div class="dropdown">
                <a href="#" class="d-block link-dark text-decoration-none" id="logoutDropdown" data-bs-toggle="dropdown" aria-expanded="false">

                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatarUrl() }}"
                             class="rounded-circle" width="36" height="36"
                             style="object-fit:cover;">
                    @else
                        <i class="bi bi-person-circle text-primary" style="font-size:36px; line-height:1;"></i>
                    @endif
                    
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