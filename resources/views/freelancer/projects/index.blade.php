@extends('layouts.dashboard')
@section('title', 'My Projects')

@section('content')
<h4 class="fw-bold mb-4">My Projects</h4>

@if($projects->isEmpty())
    <div class="bg-white rounded-3 shadow-sm p-5 text-center text-muted">
        <i class="bi bi-kanban fs-1 d-block mb-3 opacity-25"></i>
        <p>No active projects yet.</p>
        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-primary btn-sm">
            Find Jobs
        </a>
    </div>
@else
    @foreach($projects as $project)
    @php
        $total    = $project->milestones->count();
        $approved = $project->milestones->where('status','approved')->count();
        $percent  = $total > 0 ? round(($approved / $total) * 100) : 0;
        $earned   = $project->milestones->where('status','approved')->sum('amount');
    @endphp
    <div class="bg-white rounded-3 shadow-sm p-4 mb-3">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h5 class="fw-bold mb-1">
                    <a href="{{ route('freelancer.projects.show', $project) }}"
                       class="text-decoration-none text-dark">
                        {{ $project->title }}
                    </a>
                </h5>
                <small class="text-muted">
                    <i class="bi bi-person me-1"></i>{{ $project->client->name }} ·
                    <i class="bi bi-tag me-1"></i>{{ $project->category->name ?? 'N/A' }}
                </small>
            </div>
            <span class="badge
                @if($project->status == 'in_progress') bg-primary
                @elseif($project->status == 'completed') bg-success
                @else bg-secondary @endif">
                {{ ucfirst(str_replace('_',' ',$project->status)) }}
            </span>
        </div>


        @if($total > 0)
        <div class="d-flex justify-content-between small text-muted mb-1">
            <span>{{ $approved }}/{{ $total }} milestones</span>
            <span>${{ number_format($earned) }} earned</span>
        </div>
        <div class="progress mb-3" style="height:8px;">
            <div class="progress-bar bg-success" style="width:{{ $percent }}%"></div>
        </div>
        @endif

        <a href="{{ route('freelancer.projects.show', $project) }}"
           class="btn btn-sm btn-outline-primary">
            View Project
        </a>
        <a href="{{ route('messages.show', $project) }}"
           class="btn btn-sm btn-outline-secondary ms-2">
            <i class="bi bi-chat-dots me-1"></i>Send message 
        </a>
    </div>
    @endforeach
    {{ $projects->links() }}
@endif
@endsection