@extends('layouts.dashboard')

@section('title', 'Client Dashboard')

@section('sidebar-links')
    <a href="{{ route('client.dashboard') }}" class="nav-link active">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-plus-circle"></i> Post a Job
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-briefcase"></i> My Jobs
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-people"></i> Freelancers
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-chat-dots"></i> Messages
    </a>
@endsection

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">0</div>
                    <div class="stat-label">Active Jobs</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-briefcase"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">0</div>
                    <div class="stat-label">Total Bids</div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">0</div>
                    <div class="stat-label">In Progress</div>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-clock"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">0</div>
                    <div class="stat-label">Completed</div>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="bg-white rounded-3 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">My Recent Jobs</h5>
        <a href="#" class="btn btn-primary btn-sm">
            <i class="bi bi-plus me-1"></i>Post New Job
        </a>
    </div>
    <div class="text-center py-5 text-muted">
        <i class="bi bi-briefcase fs-1 d-block mb-3 opacity-25"></i>
        <p>You haven't posted any jobs yet.</p>
        <a href="#" class="btn btn-outline-primary btn-sm">Post Your First Job</a>
    </div>
</div>
@endsection
