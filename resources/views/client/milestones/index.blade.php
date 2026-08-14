@extends('layouts.dashboard')
@section('title', __('app.create_milestones'))

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        {{-- Job Context Header --}}
        <div class="bg-white rounded-3 shadow-sm p-4 mb-3">
            <h6 class="text-muted mb-1">{{ __('app.setting_up_milestones_for') }}:</h6>
            <h5 class="fw-bold">{{ $job->title }}</h5>
            <small class="text-success">
                {{ __('app.hired') }}: <strong>{{ $job->acceptedBid->freelancer->name }}</strong>
            </small>
        </div>

        {{-- Milestones Form --}}
        <div class="bg-white rounded-3 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">{{ __('app.milestones') }}</h5>
                <button type="button" class="btn btn-outline-primary btn-sm" id="addMilestone">
                    <i class="bi bi-plus me-1"></i>{{ __('app.add_milestone') }}
                </button>
            </div>

            <form action="{{ route('client.milestones.store', $job) }}" method="POST">
                @csrf
                <div id="milestones-container">
                    <div class="milestone-item border rounded-3 p-3 mb-3">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="fw-bold milestone-title">{{ __('app.milestone') }} 1</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">{{ __('app.title') }}</label>
                                <input type="text" name="milestones[0][title]"
                                       class="form-control" placeholder="{{ __('app.milestone_title_placeholder') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('app.amount') }} ($)</label>
                                <input type="number" name="milestones[0][amount]"
                                       class="form-control" placeholder="250" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('app.due_date') }} ({{ __('app.optional') }})</label>
                                <input type="date" name="milestones[0][due_date]" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('app.description') }} ({{ __('app.optional') }})</label>
                                <input type="text" name="milestones[0][description]"
                                       class="form-control" placeholder="{{ __('app.milestone_desc_placeholder') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary px-5 mt-2">
                    <i class="bi bi-check-lg me-2"></i>{{ __('app.save_milestones') }}
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let count = 1;
// Translations passed to JS
const milestoneLabel = @json(__('app.milestone'));
const removeLabel = @json(__('app.remove'));
const titleLabel = @json(__('app.title'));
const amountLabel = @json(__('app.amount'));
const dueDateLabel = @json(__('app.due_date'));
const descriptionLabel = @json(__('app.description'));
const optionalLabel = @json(__('app.optional'));
const titlePlaceholder = @json(__('app.milestone_title_placeholder'));
const descPlaceholder = @json(__('app.milestone_desc_placeholder'));

document.getElementById('addMilestone').addEventListener('click', function() {
    const container = document.getElementById('milestones-container');
    const div = document.createElement('div');
    div.className = 'milestone-item border rounded-3 p-3 mb-3';
    div.innerHTML = `
        <div class="d-flex justify-content-between mb-3">
            <h6 class="fw-bold milestone-title">${milestoneLabel} ${count + 1}</h6>
            <button type="button" class="btn btn-outline-danger btn-sm remove-milestone">${removeLabel}</button>
        </div>
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">${titleLabel}</label>
                <input type="text" name="milestones[${count}][title]" class="form-control" placeholder="${titlePlaceholder}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">${amountLabel} ($)</label>
                <input type="number" name="milestones[${count}][amount]" class="form-control" placeholder="250" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">${dueDateLabel} (${optionalLabel})</label>
                <input type="date" name="milestones[${count}][due_date]" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">${descriptionLabel} (${optionalLabel})</label>
                <input type="text" name="milestones[${count}][description]" class="form-control" placeholder="${descPlaceholder}">
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