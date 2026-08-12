@extends('layouts.dashboard')
@section('title', 'Freelancer Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">{{ $stats['bids_sent'] }}</div>
                    <div class="stat-label">Bids Sent</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-send"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">{{ $stats['active_projects'] }}</div>
                    <div class="stat-label">Active Projects</div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-kanban"></i>
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
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">${{ number_format($stats['total_earned']) }}</div>
                    <div class="stat-label">Total Earned</div>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    <div class="col-lg-6">
        <div class="bg-white rounded-3 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">My Recent Bids</h5>
                <a href="{{ route('freelancer.bids.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            @forelse($recentBids as $bid)
                @if($bid->job)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div class="fw-semibold small">{{ Str::limit($bid->job->title, 35) }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">
                            ${{ number_format($bid->amount) }} · {{ $bid->delivery_days }} days
                        </div>
                    </div>
                    <span class="badge
                        @if($bid->status == 'pending') bg-warning text-dark
                        @elseif($bid->status == 'accepted') bg-success
                        @elseif($bid->status == 'rejected') bg-danger
                        @else bg-secondary @endif">
                        {{ ucfirst($bid->status) }}
                    </span>
                </div>
                @endif
            @empty
                <p class="text-muted text-center py-3">No bids yet.</p>
            @endforelse
        </div>
    </div>


    <div class="col-lg-6">
        <div class="bg-white rounded-3 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Available Jobs</h5>
                <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-sm btn-outline-primary">Browse All</a>
            </div>
            @forelse($availableJobs as $job)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div>
                    <a href="{{ route('freelancer.jobs.show', $job) }}"
                       class="fw-semibold small text-decoration-none text-dark">
                        {{ Str::limit($job->title, 35) }}
                    </a>
                    <div class="text-muted" style="font-size:0.75rem;">
                        {{ $job->category->name ?? 'N/A' }} ·
                        ${{ number_format($job->budget_min) }}
                        @if($job->budget_max)– ${{ number_format($job->budget_max) }}@endif
                    </div>
                </div>
                <small class="text-muted">{{ $job->bids_count }} bids</small>
            </div>
            @empty
                <p class="text-muted text-center py-3">No jobs available.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection