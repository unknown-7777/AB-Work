@extends('layouts.dashboard')
@section('title', 'Admin Dashboard')

@section('content')


<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">{{ $stats['total_users'] }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">{{ $stats['total_clients'] }}</div>
                    <div class="stat-label">Clients</div>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-person-badge"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">{{ $stats['total_freelancers'] }}</div>
                    <div class="stat-label">Freelancers</div>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-laptop"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">{{ $stats['total_jobs'] }}</div>
                    <div class="stat-label">Total Jobs</div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-briefcase"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number text-success">{{ $stats['open_jobs'] }}</div>
                    <div class="stat-label">Open Jobs</div>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-door-open"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number text-primary">{{ $stats['in_progress_jobs'] }}</div>
                    <div class="stat-label">In Progress</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number text-secondary">{{ $stats['completed_jobs'] }}</div>
                    <div class="stat-label">Completed</div>
                </div>
                <div class="stat-icon bg-secondary bg-opacity-10 text-secondary">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row g-4">

    <div class="col-lg-6">
        <div class="bg-white rounded-3 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Recent Users</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            @foreach($recentUsers as $user)
            <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=fff&size=32"
                         class="rounded-circle" width="32" height="32">
                    <div>
                        <div class="fw-semibold small">{{ $user->name }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">{{ $user->email }}</div>
                    </div>
                </div>
                <span class="badge
                    @if($user->role == 'admin') bg-danger
                    @elseif($user->role == 'client') bg-info
                    @else bg-success @endif">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            @endforeach
        </div>
    </div>


    <div class="col-lg-6">
        <div class="bg-white rounded-3 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Recent Jobs</h5>
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            @foreach($recentJobs as $job)
            <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                <div>
                    <div class="fw-semibold small">{{ Str::limit($job->title, 35) }}</div>
                    <div class="text-muted" style="font-size:0.75rem;">
                        {{ $job->client->name }} · {{ $job->category->name ?? 'N/A' }}
                    </div>
                </div>
                <span class="badge
                    @if($job->status == 'open') bg-success
                    @elseif($job->status == 'in_progress') bg-primary
                    @elseif($job->status == 'completed') bg-secondary
                    @else bg-danger @endif">
                    {{ ucfirst(str_replace('_',' ',$job->status)) }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection