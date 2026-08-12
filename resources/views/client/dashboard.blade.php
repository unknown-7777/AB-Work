@extends('layouts.dashboard')
@section('title', 'Client Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">{{ $stats['active_jobs'] }}</div>
                    <div class="stat-label">Active Jobs</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-briefcase"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">{{ $stats['total_bids'] }}</div>
                    <div class="stat-label">Total Bids</div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">{{ $stats['in_progress'] }}</div>
                    <div class="stat-label">In Progress</div>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-clock"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">{{ $stats['completed'] }}</div>
                    <div class="stat-label">Completed</div>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-3 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">My Recent Jobs</h5>
        <a href="{{ route('client.jobs.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus me-1"></i>Post New Job
        </a>
    </div>

    @if($recentJobs->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-briefcase fs-1 d-block mb-3 opacity-25"></i>
            <p>You haven't posted any jobs yet.</p>
            <a href="{{ route('client.jobs.create') }}" class="btn btn-outline-primary btn-sm">
                Post Your First Job
            </a>
        </div>
    @else
        @foreach($recentJobs as $job)
        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
            <div>
                <a href="{{ route('client.jobs.show', $job) }}"
                   class="fw-semibold text-decoration-none text-dark">
                    {{ $job->title }}
                </a>
                <div class="text-muted small">
                    <i class="bi bi-tag me-1"></i>{{ $job->category->name ?? 'N/A' }} ·
                    {{ $job->created_at->diffForHumans() }}
                </div>
            </div>
            <div class="text-end">
                <span class="badge
                    @if($job->status == 'open') bg-success
                    @elseif($job->status == 'in_progress') bg-primary
                    @elseif($job->status == 'completed') bg-secondary
                    @else bg-danger @endif">
                    {{ ucfirst(str_replace('_',' ',$job->status)) }}
                </span>
                <div class="text-muted small mt-1">
                    <i class="bi bi-people me-1"></i>{{ $job->bids_count }} bids
                </div>
            </div>
        </div>
        @endforeach
        <div class="text-center mt-3">
            <a href="{{ route('client.jobs.index') }}" class="btn btn-outline-primary btn-sm">
                View All Jobs
            </a>
        </div>
    @endif
</div>
@endsection