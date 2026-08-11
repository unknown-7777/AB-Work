@extends('layouts.dashboard')
@section('title', 'Browse Jobs')

@section('content')

<form method="GET" class="bg-white rounded-3 shadow-sm p-3 mb-4">
    <div class="row g-2">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control"
                   placeholder="Search jobs..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="budget_type" class="form-select">
                <option value="">Any Budget</option>
                <option value="fixed"  {{ request('budget_type') == 'fixed'  ? 'selected' : '' }}>Fixed</option>
                <option value="hourly" {{ request('budget_type') == 'hourly' ? 'selected' : '' }}>Hourly</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                <i class="bi bi-search me-1"></i>Search
            </button>
        </div>
    </div>
</form>


@if($jobs->isEmpty())
    <div class="bg-white rounded-3 shadow-sm p-5 text-center text-muted">
        <i class="bi bi-search fs-1 d-block mb-3 opacity-25"></i>
        <p>No jobs found.</p>
    </div>
@else
    @foreach($jobs as $job)
    <div class="bg-white rounded-3 shadow-sm p-4 mb-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="fw-bold mb-1">
                    <a href="{{ route('freelancer.jobs.show', $job) }}"
                       class="text-decoration-none text-dark">
                        {{ $job->title }}
                    </a>
                </h5>
                <small class="text-muted">
                    <i class="bi bi-tag me-1"></i>{{ $job->category->name ?? 'N/A' }} ·
                    <i class="bi bi-person me-1"></i>{{ $job->client->name }} ·
                    <i class="bi bi-clock me-1"></i>{{ $job->created_at->diffForHumans() }}
                </small>
                <p class="mt-2 mb-2 text-muted small">
                    {{ Str::limit($job->description, 150) }}
                </p>
                @if($job->required_skills)
                    @foreach($job->required_skills as $skill)
                        <span class="badge bg-primary bg-opacity-10 text-primary me-1">{{ $skill }}</span>
                    @endforeach
                @endif
            </div>
            <div class="text-end ms-3" style="min-width:120px;">
                <div class="fw-bold text-success">
                    ${{ number_format($job->budget_min) }}
                    @if($job->budget_max) – ${{ number_format($job->budget_max) }} @endif
                </div>
                <small class="text-muted">{{ ucfirst($job->budget_type) }}</small>
                <div class="mt-2">
                    <small class="text-muted"><i class="bi bi-people me-1"></i>{{ $job->bids_count }} bids</small>
                </div>
                <a href="{{ route('freelancer.jobs.show', $job) }}"
                   class="btn btn-outline-primary btn-sm mt-2">View</a>
            </div>
        </div>
    </div>
    @endforeach
    {{ $jobs->links() }}
@endif
@endsection