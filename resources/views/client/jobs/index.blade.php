@extends('layouts.dashboard')
@section('title', __('app.my_jobs'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">{{ __('app.my_jobs') }}</h4>
    <a href="{{ route('client.jobs.create') }}" class="btn btn-primary">
        <i class="bi bi-plus me-1"></i>{{ __('app.post_new_job') }}
    </a>
</div>

@if($jobs->isEmpty())
    <div class="bg-white rounded-3 shadow-sm p-5 text-center text-muted">
        <i class="bi bi-briefcase fs-1 d-block mb-3 opacity-25"></i>
        <p>{{ __('app.no_jobs_posted_yet') }}</p>
        <a href="{{ route('client.jobs.create') }}" class="btn btn-outline-primary btn-sm">{{ __('app.post_your_first_job') }}</a>
    </div>
@else
    @foreach($jobs as $job)
    <div class="bg-white rounded-3 shadow-sm p-4 mb-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="fw-bold mb-1">
                    <a href="{{ route('client.jobs.show', $job) }}" class="text-decoration-none text-dark">
                        {{ $job->title }}
                    </a>
                </h5>
                <small class="text-muted">
                    <i class="bi bi-tag me-1"></i>{{ $job->category->name ?? __('app.not_available') }} ·
                    <i class="bi bi-clock me-1"></i>{{ $job->created_at->diffForHumans() }}
                </small>
            </div>
            <div class="text-end">
                <span class="badge
                    @if($job->status == 'open') bg-success
                    @elseif($job->status == 'in_progress') bg-primary
                    @elseif($job->status == 'completed') bg-secondary
                    @else bg-danger @endif">
                    {{ __('app.' . $job->status) }}
                </span>
                <div class="mt-2 text-muted small">
                    <i class="bi bi-people me-1"></i>{{ $job->bids_count }} {{ __('app.bids') }}
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{ $jobs->links() }}
@endif
@endsection