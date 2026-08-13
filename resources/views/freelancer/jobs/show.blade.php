@extends('layouts.dashboard')
@section('title', $job->title)

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
            <h4 class="fw-bold">{{ $job->title }}</h4>
            <small class="text-muted">
                <i class="bi bi-tag me-1"></i>{{ $job->category->name ?? 'N/A' }} ·
                <i class="bi bi-clock me-1"></i>{{ $job->created_at->diffForHumans() }}
            </small>
            <hr>
            <p class="text-muted" style="white-space: pre-wrap; word-wrap: break-word; overflow-wrap: break-word;">{{ $job->description }}</p>

            @if($job->required_skills)
                <h6 class="fw-bold mt-3">Required Skills</h6>
                @foreach($job->required_skills as $skill)
                    <span class="badge bg-primary bg-opacity-10 text-primary me-1">{{ $skill }}</span>
                @endforeach
            @endif
        </div>
    </div>

    <div class="col-lg-4">

        <div class="bg-white rounded-3 shadow-sm p-4 mb-3">
            <h6 class="fw-bold mb-3">Job Details</h6>
            <div class="mb-2 d-flex justify-content-between">
                <span class="text-muted">Budget</span>
                <span class="fw-semibold text-success">
                    ${{ number_format($job->budget_min) }}
                    @if($job->budget_max)– ${{ number_format($job->budget_max) }}@endif
                </span>
            </div>
            <div class="mb-2 d-flex justify-content-between">
                <span class="text-muted">Type</span>
                <span>{{ ucfirst($job->budget_type) }}</span>
            </div>
            <div class="mb-2 d-flex justify-content-between">
                <span class="text-muted">Level</span>
                <span>{{ ucfirst($job->experience_level) }}</span>
            </div>
            <div class="mb-2 d-flex justify-content-between">
                <span class="text-muted">Bids</span>
                <span>{{ $job->bids_count }}</span>
            </div>
            @if($job->deadline)
            <div class="mb-2 d-flex justify-content-between">
                <span class="text-muted">Deadline</span>
                <span>{{ $job->deadline->format('M d, Y') }}</span>
            </div>
            @endif
            <hr>
            @if($hasAlreadyBid)
                <div class="alert alert-info mb-0 small">
                    <i class="bi bi-check-circle me-1"></i>You already submitted a bid.
                </div>
            @else
                <a href="{{ route('freelancer.bids.create', $job) }}"
                   class="btn btn-primary w-100">
                    <i class="bi bi-send me-2"></i>Submit a Bid
                </a>
            @endif
        </div>


        <div class="bg-white rounded-3 shadow-sm p-4">
            <h6 class="fw-bold mb-3">About the Client</h6>
            <div class="d-flex align-items-center gap-2">
                
                @if($user->avatar)
                    <img src="{{ $user->avatarUrl() }}"
                         class="rounded-circle" width="28" height="28"
                         style="object-fit:cover;">
                @else
                    <i class="bi bi-person-circle text-primary" style="font-size:28px; line-height:1;"></i>
                @endif
                
                <div>
                    <div class="fw-semibold">{{ $job->client->name }}</div>
                    <small class="text-muted">Member since {{ $job->client->created_at->format('M Y') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection