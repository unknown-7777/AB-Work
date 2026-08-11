@extends('layouts.dashboard')
@section('title', 'Submit a Bid')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="bg-white rounded-3 shadow-sm p-4 mb-3">
            <h6 class="fw-bold text-muted mb-1">Bidding on:</h6>
            <h5 class="fw-bold">{{ $job->title }}</h5>
            <small class="text-success fw-semibold">
                Budget: ${{ number_format($job->budget_min) }}
                @if($job->budget_max)– ${{ number_format($job->budget_max) }}@endif
            </small>
        </div>

        <div class="bg-white rounded-3 shadow-sm p-4">
            <h5 class="fw-bold mb-4">Your Proposal</h5>
            <form action="{{ route('freelancer.bids.store', $job) }}" method="POST">
                @csrf
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Your Bid Amount ($)</label>
                        <input type="number" name="amount"
                               class="form-control @error('amount') is-invalid @enderror"
                               value="{{ old('amount') }}" placeholder="e.g. 500">
                        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Delivery Time (days)</label>
                        <input type="number" name="delivery_days"
                               class="form-control @error('delivery_days') is-invalid @enderror"
                               value="{{ old('delivery_days') }}" placeholder="e.g. 7">
                        @error('delivery_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Cover Letter</label>
                    <textarea name="cover_letter" rows="7"
                              class="form-control @error('cover_letter') is-invalid @enderror"
                              placeholder="Explain why you're the best fit for this job...">{{ old('cover_letter') }}</textarea>
                    @error('cover_letter') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Minimum 50 characters</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-send me-2"></i>Submit Bid
                    </button>
                    <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection