@extends('layouts.dashboard')
@section('title', __('app.my_projects'))

@section('content')
<h4 class="fw-bold mb-4">{{ __('app.my_projects') }}</h4>

@if($projects->isEmpty())
    <div class="bg-white rounded-3 shadow-sm p-5 text-center text-muted">
        <i class="bi bi-kanban fs-1 d-block mb-3 opacity-25"></i>
        <p>{{ __('app.no_active_projects') }}</p>
        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-primary btn-sm">
            {{ __('app.find_jobs') }}
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
                        <i class="bi bi-tag me-1"></i>{{ $project->category->name ?? __('app.no_data') }}
                    </small>
                </div>
                <span class="badge
                    @if($project->status === 'in_progress') bg-primary
                    @elseif($project->status === 'completed') bg-success
                    @else bg-secondary @endif">
                    {{ \Illuminate\Support\Facades\Lang::has('app.status_' . $project->status, app()->getLocale()) 
                        ? __('app.status_' . $project->status) 
                        : ucfirst(str_replace('_', ' ', $project->status)) }}
                </span>
            </div>

            @if($total > 0)
            <div class="d-flex justify-content-between small text-muted mb-1">
                <span>{{ __('app.milestones_count', ['approved' => $approved, 'total' => $total]) }}</span>
                <span>{{ __('app.amount_earned', ['amount' => number_format($earned)]) }}</span>
            </div>
            <div class="progress mb-3" style="height:8px;">
                <div class="progress-bar bg-success" style="width:{{ $percent }}%"></div>
            </div>
            @endif

            <a href="{{ route('freelancer.projects.show', $project) }}"
               class="btn btn-sm btn-outline-primary">
                {{ __('app.view_project') }}
            </a>
            <a href="{{ route('messages.show', $project) }}"
               class="btn btn-sm btn-outline-secondary ms-2">
                <i class="bi bi-chat-dots me-1"></i>{{ __('app.send_message') }}
            </a>
        </div>
    @endforeach

    {{ $projects->links() }}
@endif
@endsection