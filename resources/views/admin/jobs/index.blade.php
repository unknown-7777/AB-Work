@extends('layouts.dashboard')
@section('title', 'Manage Jobs')

@section('content')
<h4 class="fw-bold mb-4">Manage Jobs</h4>

<form method="GET" class="bg-white rounded-3 shadow-sm p-3 mb-4">
    <div class="row g-2">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control"
                   placeholder="Search jobs..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="open"        {{ request('status') == 'open'        ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed"   {{ request('status') == 'completed'   ? 'selected' : '' }}>Completed</option>
                <option value="cancelled"   {{ request('status') == 'cancelled'   ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </div>
</form>

<div class="bg-white rounded-3 shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Client</th>
                <th>Category</th>
                <th>Budget</th>
                <th>Status</th>
                <th>Bids</th>
                <th>Posted</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
            <tr>
                <td>{{ $job->id }}</td>
                <td>{{ Str::limit($job->title, 30) }}</td>
                <td>{{ $job->client->name }}</td>
                <td>{{ $job->category->name ?? 'N/A' }}</td>
                <td class="text-success fw-semibold">
                    ${{ number_format($job->budget_min) }}
                    @if($job->budget_max)– ${{ number_format($job->budget_max) }}@endif
                </td>
                <td>
                    <span class="badge
                        @if($job->status == 'open') bg-success
                        @elseif($job->status == 'in_progress') bg-primary
                        @elseif($job->status == 'completed') bg-secondary
                        @else bg-danger @endif">
                        {{ ucfirst(str_replace('_',' ',$job->status)) }}
                    </span>
                </td>
                <td>{{ $job->bids_count }}</td>
                <td>{{ $job->created_at->format('M d, Y') }}</td>
                <td>
                    <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this job?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-3">{{ $jobs->links() }}</div>
</div>
@endsection