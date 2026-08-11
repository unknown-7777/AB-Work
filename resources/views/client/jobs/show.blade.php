@extends('layouts.dashboard')
@section('title', $job->title)

@section('content')
<div class="row g-4">


    <div class="col-lg-8">
        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h4 class="fw-bold">{{ $job->title }}</h4>
                    <small class="text-muted">
                        <i class="bi bi-tag me-1"></i>{{ $job->category->name ?? 'N/A' }} ·
                        <i class="bi bi-clock me-1"></i>{{ $job->created_at->diffForHumans() }}
                    </small>
                </div>
                <span class="badge
                    @if($job->status == 'open') bg-success
                    @elseif($job->status == 'in_progress') bg-primary
                    @elseif($job->status == 'completed') bg-secondary
                    @else bg-danger @endif fs-6">
                    {{ ucfirst(str_replace('_', ' ', $job->status)) }}
                </span>
            </div>
            <hr>
            <p class="text-muted" style="white-space:pre-line;">{{ $job->description }}</p>
            @if($job->required_skills)
                <h6 class="fw-bold mt-3">Required Skills</h6>
                @foreach($job->required_skills as $skill)
                    <span class="badge bg-primary bg-opacity-10 text-primary me-1">{{ $skill }}</span>
                @endforeach
            @endif
        </div>


        <div class="bg-white rounded-3 shadow-sm p-4">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-people me-2"></i>Bids ({{ $job->bids_count }})
            </h5>

            @if($job->bids->isEmpty())
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                    <p>No bids yet.</p>
                </div>
            @else
                @foreach($job->bids as $bid)
                <div class="border rounded-3 p-3 mb-3
                    @if($bid->isAccepted()) border-success bg-success bg-opacity-10 @endif">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($bid->freelancer->name) }}&background=2563eb&color=fff&size=40"
                                 class="rounded-circle" width="44" height="44">
                            <div>
                                <div class="fw-bold">{{ $bid->freelancer->name }}</div>
                                <small class="text-muted">
                                    {{ $bid->freelancer->profile->title ?? 'Freelancer' }}
                                </small>
                                <div class="mt-1">
                                    <span class="fw-bold text-success">${{ number_format($bid->amount) }}</span>
                                    <span class="text-muted small ms-2">
                                        · {{ $bid->delivery_days }} days delivery
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge
                                @if($bid->status == 'pending')  bg-warning text-dark
                                @elseif($bid->status == 'accepted') bg-success
                                @elseif($bid->status == 'rejected') bg-danger
                                @else bg-secondary @endif">
                                {{ ucfirst($bid->status) }}
                            </span>
                        </div>
                    </div>

                    <p class="mt-3 mb-3 text-muted small">{{ $bid->cover_letter }}</p>

                    @if($job->isOpen() && $bid->isPending())
                    <div class="d-flex gap-2">
                        <form action="{{ route('client.bids.accept', $bid) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-success btn-sm">
                                <i class="bi bi-check-lg me-1"></i>Accept
                            </button>
                        </form>
                        <form action="{{ route('client.bids.reject', $bid) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-x-lg me-1"></i>Reject
                            </button>
                        </form>
                    </div>
                    @endif

                    @if($bid->isAccepted())
                        <span class="badge bg-success mt-2">
                            <i class="bi bi-check-circle me-1"></i>Hired
                        </span>
                    @endif
                </div>
                @endforeach
            @endif
        </div>
    </div>


    <div class="col-lg-4">
        <div class="bg-white rounded-3 shadow-sm p-4">
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
                <span class="text-muted">Total Bids</span>
                <span>{{ $job->bids_count }}</span>
            </div>
            @if($job->deadline)
            <div class="mb-2 d-flex justify-content-between">
                <span class="text-muted">Deadline</span>
                <span>{{ $job->deadline->format('M d, Y') }}</span>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection