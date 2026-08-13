@extends('layouts.dashboard')
@section('title', $job->title)

@section('content')
@php use App\Models\Review; @endphp


<div class="bg-white rounded-3 shadow-sm p-4 mb-4">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h4 class="fw-bold mb-1">{{ $job->title }}</h4>
            <small class="text-muted">
                <i class="bi bi-person me-1"></i>Client: <strong>{{ $job->client->name }}</strong> ·
                <i class="bi bi-tag me-1"></i>{{ $job->category->name ?? 'N/A' }}
            </small>
        </div>
        <div class="text-end">
            <span class="badge fs-6
                @if($job->status == 'in_progress') bg-primary
                @elseif($job->status == 'completed') bg-success
                @else bg-secondary @endif">
                {{ ucfirst(str_replace('_',' ',$job->status)) }}
            </span>
            <!--<div class="mt-2">
                <a href="{{ route('messages.show', $job) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-chat-dots me-1"></i>Message Client
                </a>
            </div>-->
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">


        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-kanban me-2"></i>Milestones
            </h5>

            @if($job->milestones->isEmpty())
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-hourglass fs-1 d-block mb-2 opacity-25"></i>
                    <p>Waiting for client to create milestones.</p>
                </div>
            @else
                @foreach($job->milestones as $milestone)
                <div class="border rounded-3 p-4 mb-3
                    @if($milestone->isApproved()) border-success
                    @elseif($milestone->status == 'submitted') border-warning
                    @elseif($milestone->status == 'revision') border-danger
                    @endif">


                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-1">
                                {{ $milestone->order }}. {{ $milestone->title }}
                            </h6>
                            @if($milestone->description)
                                <p class="text-muted small mb-1">{{ $milestone->description }}</p>
                            @endif
                            <span class="fw-bold text-success">${{ number_format($milestone->amount) }}</span>
                            @if($milestone->due_date)
                                <span class="text-muted small ms-2">
                                    · Due: {{ $milestone->due_date->format('M d, Y') }}
                                    @if($milestone->isOverdue())
                                        <span class="badge bg-danger ms-1">Overdue</span>
                                    @endif
                                </span>
                            @endif
                        </div>
                        <span class="badge {{ $milestone->statusBadgeClass() }}">
                            {{ ucfirst(str_replace('_',' ',$milestone->status)) }}
                        </span>
                    </div>


                    @if($milestone->revision_note)
                        <div class="alert alert-danger py-2 small mt-2">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            <strong>Revision requested:</strong> {{ $milestone->revision_note }}
                        </div>
                    @endif


                    @if($milestone->isApproved())
                        <div class="alert alert-success py-2 small mt-2 mb-0">
                            <i class="bi bi-check-circle me-1"></i>
                            Approved & Payment released on
                            {{ $milestone->payment_released_at->format('M d, Y') }}
                        </div>
                    @endif


                    @if($milestone->status === 'submitted')
                        <div class="alert alert-warning py-2 small mt-2 mb-0">
                            <i class="bi bi-hourglass-split me-1"></i>
                            Submitted — waiting for client approval.
                        </div>
                    @endif


                    @if(in_array($milestone->status, ['pending', 'in_progress', 'revision']))
                        <form action="{{ route('freelancer.milestones.submit', $milestone) }}"
                              method="POST" class="mt-3">
                            @csrf @method('PATCH')
                            <label class="form-label fw-semibold small">
                                Delivery Note
                                <span class="text-muted fw-normal">(describe what you completed)</span>
                            </label>
                            <textarea name="submission_note" rows="3"
                                      class="form-control form-control-sm mb-2"
                                      placeholder="e.g. I have completed the homepage design with responsive layout..."
                                      required>{{ old('submission_note') }}</textarea>
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-send me-1"></i>Submit for Review
                            </button>
                        </form>
                    @endif
                </div>
                @endforeach
            @endif
        </div>


        @if($job->isCompleted())
        <div class="bg-white rounded-3 shadow-sm p-4">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-star me-2"></i>Leave a Review
            </h5>
            @if(Review::where('job_id', $job->id)->where('reviewer_id', auth()->id())->exists())
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>You already submitted a review for this project.
                </div>
            @else
                <p class="text-muted small mb-3">
                    Share your experience working with {{ $job->client->name }}.
                </p>
                <a href="{{ route('reviews.create', $job) }}" class="btn btn-warning">
                    <i class="bi bi-star me-2"></i>Leave a Review
                </a>
            @endif
        </div>
        @endif

    </div>


    <div class="col-lg-4">


        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
            <h6 class="fw-bold mb-3">Project Progress</h6>
            @php
                $total    = $job->milestones->count();
                $approved = $job->milestones->where('status', 'approved')->count();
                $percent  = $total > 0 ? round(($approved / $total) * 100) : 0;
                $earned   = $job->milestones->where('status', 'approved')->sum('amount');
                $pending  = $job->milestones->where('status', '!=', 'approved')->sum('amount');
            @endphp

            <div class="d-flex justify-content-between small text-muted mb-1">
                <span>{{ $approved }}/{{ $total }} milestones done</span>
                <span>{{ $percent }}%</span>
            </div>
            <div class="progress mb-3" style="height:10px;">
                <div class="progress-bar bg-success" style="width:{{ $percent }}%"></div>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted small">Earned so far</span>
                <span class="fw-bold text-success">${{ number_format($earned) }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted small">Pending payment</span>
                <span class="fw-bold text-warning">${{ number_format($pending) }}</span>
            </div>
        </div>


        <div class="bg-white rounded-3 shadow-sm p-4">
            <h6 class="fw-bold mb-3">Client</h6>
            <div class="d-flex align-items-center gap-3">
                @if($job->client->avatar)
                    <img src="{{ $job->client->avatarUrl() }}"
                         class="rounded-circle" width="44" height="44"
                         style="object-fit:cover;">
                @else
                    <i class="bi bi-person-circle text-primary" style="font-size:44px;"></i>
                @endif
                <div>
                    <div class="fw-bold">{{ $job->client->name }}</div>
                    <small class="text-muted">
                        Member since {{ $job->client->created_at->format('M Y') }}
                    </small>
                </div>
            </div>
            <a href="{{ route('messages.show', $job) }}"
               class="btn btn-sm btn-outline-secondary btn-sm w-100 mt-3">
                <i class="bi bi-chat-dots me-1"></i>Send Message
            </a>
        </div>

    </div>
</div>
@endsection