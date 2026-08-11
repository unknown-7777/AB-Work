@extends('layouts.dashboard')
@section('title', $job->title)

@section('content')
<div class="bg-white rounded-3 shadow-sm p-4 mb-4">
    <h4 class="fw-bold">{{ $job->title }}</h4>
    <small class="text-muted">Client: {{ $job->client->name }}</small>
</div>

<h5 class="fw-bold mb-3">Milestones</h5>

@if($job->milestones->isEmpty())
    <div class="bg-white rounded-3 shadow-sm p-4 text-center text-muted">
        <p>No milestones set yet. Wait for the client to create them.</p>
    </div>
@else
    @foreach($job->milestones as $milestone)
    <div class="bg-white rounded-3 shadow-sm p-4 mb-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h6 class="fw-bold">{{ $milestone->order }}. {{ $milestone->title }}</h6>
                <small class="text-muted">{{ $milestone->description }}</small>
                <div class="mt-1 fw-semibold text-success">${{ number_format($milestone->amount) }}</div>
                @if($milestone->due_date)
                    <small class="text-muted">Due: {{ $milestone->due_date->format('M d, Y') }}</small>
                @endif
            </div>
            <span class="badge {{ $milestone->statusBadgeClass() }}">
                {{ ucfirst(str_replace('_', ' ', $milestone->status)) }}
            </span>
        </div>

        @if($milestone->revision_note)
            <div class="alert alert-warning mt-3 mb-2 small">
                <strong>Revision requested:</strong> {{ $milestone->revision_note }}
            </div>
        @endif

        @if(in_array($milestone->status, ['pending', 'in_progress', 'revision']))
        <form action="{{ route('freelancer.milestones.submit', $milestone) }}"
              method="POST" class="mt-3">
            @csrf @method('PATCH')
            <div class="mb-2">
                <textarea name="submission_note" class="form-control form-control-sm"
                          rows="2" placeholder="Describe what you've completed..." required></textarea>
            </div>
            <button class="btn btn-primary btn-sm">
                <i class="bi bi-send me-1"></i>Submit for Review
            </button>
        </form>
        @endif

        @if($milestone->isApproved())
            <div class="alert alert-success mt-3 mb-0 small">
                <i class="bi bi-check-circle me-1"></i>
                Approved & Payment released on {{ $milestone->payment_released_at->format('M d, Y') }}
            </div>
        @endif
    </div>
    @endforeach
@endif
@endsection