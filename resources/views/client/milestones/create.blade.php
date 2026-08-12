@extends('layouts.dashboard')
@section('title', 'Create Milestones')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="bg-white rounded-3 shadow-sm p-4 mb-3">
            <h6 class="text-muted mb-1">Setting up milestones for:</h6>
            <h5 class="fw-bold">{{ $job->title }}</h5>
            <small class="text-success">
                Hired: <strong>{{ $job->acceptedBid->freelancer->name }}</strong>
            </small>
        </div>

        <div class="bg-white rounded-3 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Project Milestones</h5>
                <button type="button" class="btn btn-outline-primary btn-sm" id="addMilestone">
                    <i class="bi bi-plus me-1"></i>Add Milestone
                </button>
            </div>

            <form action="{{ route('client.milestones.store', $job) }}" method="POST">
                @csrf
                <div id="milestones-container">
                    <div class="milestone-item border rounded-3 p-3 mb-3">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="fw-bold">Milestone 1</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Title</label>
                                <input type="text" name="milestones[0][title]"
                                       class="form-control" placeholder="e.g. Project Setup & Design">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Amount ($)</label>
                                <input type="number" name="milestones[0][amount]"
                                       class="form-control" placeholder="250">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Due Date (optional)</label>
                                <input type="date" name="milestones[0][due_date]" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Description (optional)</label>
                                <input type="text" name="milestones[0][description]"
                                       class="form-control" placeholder="What should be delivered?">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary px-5 mt-2">
                    <i class="bi bi-check-lg me-2"></i>Save Milestones
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let count = 1;
document.getElementById('addMilestone').addEventListener('click', function() {
    const container = document.getElementById('milestones-container');
    const div = document.createElement('div');
    div.className = 'milestone-item border rounded-3 p-3 mb-3';
    div.innerHTML = `
        <div class="d-flex justify-content-between mb-3">
            <h6 class="fw-bold">Milestone ${count + 1}</h6>
            <button type="button" class="btn btn-outline-danger btn-sm remove-milestone">Remove</button>
        </div>
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Title</label>
                <input type="text" name="milestones[${count}][title]" class="form-control" placeholder="e.g. Backend Development">
            </div>
            <div class="col-md-4">
                <label class="form-label">Amount ($)</label>
                <input type="number" name="milestones[${count}][amount]" class="form-control" placeholder="250">
            </div>
            <div class="col-md-6">
                <label class="form-label">Due Date (optional)</label>
                <input type="date" name="milestones[${count}][due_date]" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Description (optional)</label>
                <input type="text" name="milestones[${count}][description]" class="form-control" placeholder="What should be delivered?">
            </div>
        </div>`;
    container.appendChild(div);
    count++;

    div.querySelector('.remove-milestone').addEventListener('click', function() {
        div.remove();
    });
});
</script>
@endpush
@endsection