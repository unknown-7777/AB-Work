@extends('layouts.dashboard')

@section('title', 'Freelancer Dashboard')

@section('sidebar-links')
    <a href="{{ route('freelancer.dashboard') }}" class="nav-link active">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-search"></i> Find Jobs
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-file-earmark-text"></i> My Bids
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-kanban"></i> My Projects
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-chat-dots"></i> Messages
    </a>
    <a href="#" class="nav-link">
        <i class="bi bi-person-circle"></i> My Profile
    </a>
@endsection

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">0</div>
                    <div class="stat-label">Bids Sent</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-send"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">0</div>
                    <div class="stat-label">Active Projects</div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-kanban"></i>
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
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-number">$0</div>
                    <div class="stat-label">Total Earned</div>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="bg-white rounded-3 shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Available Jobs</h5>
        <a href="#" class="btn btn-primary btn-sm">
            <i class="bi bi-search me-1"></i>Browse All
        </a>
    </div>
    <div class="text-center py-5 text-muted">
        <i class="bi bi-search fs-1 d-block mb-3 opacity-25"></i>
        <p>No jobs available yet. Check back soon!</p>
        <a href="#" class="btn btn-outline-primary btn-sm">Browse Jobs</a>
    </div>
</div>
@endsection