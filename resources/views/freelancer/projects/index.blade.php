@extends('layouts.dashboard')
@section('title', 'My Projects')

@section('content')
<h4 class="fw-bold mb-4">My Projects</h4>

@if($projects->isEmpty())
    <div class="bg-white rounded-3 shadow-sm p-5 text-center text-muted">
        <i class="bi bi-kanban fs-1 d-block mb-3 opacity-25"></i>
        <p>No active projects yet.</p>
        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-primary btn-sm">Find Jobs</a>
    </div>
@else
    @foreach($projects as $project)
    <div class="bg-white rounded-3 shadow-sm p-4 mb-3">
        <div class="d-flex justify-content-between align-items-start">
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
                <div class="mt-2">
                    <small class="text-muted">
                        {{ $project->milestones->where('status','approved')->count() }}
                        / {{ $project->milestones->count() }} milestones completed
                    </small>
                </div>
            </div>
            <span class="badge
                @if($project->status == 'in_progress') bg-primary
                @elseif($project->status == 'completed') bg-success
                @else bg-secondary @endif">
                {{ ucfirst(str_replace('_',' ',$project->status)) }}
            </span>
        </div>
    </div>
    @endforeach
    {{ $projects->links() }}
@endif
@endsection