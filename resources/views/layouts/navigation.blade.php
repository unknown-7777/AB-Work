<nav class="navbar navbar-expand-sm navbar-white bg-white border-bottom py-2 shadow-sm">
    <div class="container-fluid px-4">
        
        <a class="navbar-brand d-flex align-items-center me-4" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isClient() ? route('client.dashboard') : route('freelancer.dashboard')) }}">
            <i class="bi bi-briefcase-fill text-primary fs-3"></i>
            <span class="fw-bold text-dark ms-2 small">{{ config('app.name', 'ABWork') }}</span>
        </a>

        <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarContent" aria-controls="mainNavbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-3 text-secondary"></i>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbarContent">
            
            <ul class="navbar-nav me-auto mb-2 mb-sm-0">
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-2 py-2 small {{ request()->routeIs('admin.dashboard') || request()->routeIs('client.dashboard') || request()->routeIs('freelancer.dashboard') ? 'text-primary active' : 'text-secondary' }}" 
                       href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isClient() ? route('client.dashboard') : route('freelancer.dashboard')) }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>
            </ul>

            <div class="d-sm-none border-top border-light my-2 pt-2">
                <div class="px-2 mb-3">
                    <div class="fw-bold text-dark small">{{ Auth::user()->name }}</div>
                    <div class="text-muted small fs-7">{{ Auth::user()->email }}</div>
                </div>
                <a class="dropdown-item py-2 px-2 text-secondary small rounded-3" href="{{ route('profile.edit') }}">
                    <i class="bi bi-person me-2"></i> {{ __('Profile') }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="d-block">
                    @csrf
                    <button type="submit" class="dropdown-item py-2 px-2 text-danger small rounded-3">
                        <i class="bi bi-box-arrow-right me-2"></i> {{ __('Log Out') }}
                    </button>
                </form>
            </div>

            <ul class="navbar-nav ms-auto d-none d-sm-flex align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle btn btn-light border-0 px-3 py-2 rounded-3 text-secondary fw-semibold small d-flex align-items-center gap-1" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown" 
                       aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3 p-2 mt-2" style="min-width: 200px;">
                        <li>
                            <a class="dropdown-item py-2 rounded-3 text-secondary small" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i> {{ __('Profile') }}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider border-light"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 rounded-3 text-danger small">
                                    <i class="bi bi-box-arrow-right me-2"></i> {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>