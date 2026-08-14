@extends('layouts.dashboard')
@section('title', __('app.create_milestones'))

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="bg-white rounded-3 shadow-sm p-4 mb-3">
            <h6 class="text-muted mb-1">{{ __('app.setting_up_for') }}</h6>
            <h5 class="fw-bold">{{ $job->title }}</h5>
            <small class="text-success">
                {{ __('app.hired_label') }} <strong>{{ $job->acceptedBid->freelancer->name }}</strong>
            </small>
        </div>

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
                            <h6 class="fw-bold milestone-title">{{ __('app.milestone_title') }} 1</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">{{ __('app.milestone_title') }}</label>
                                <input type="text" name="milestones[0][title]"
                                       class="form-control" placeholder="{{ __('app.milestone_deliver') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('app.milestone_amount') }}</label>
                                <input type="number" name="milestones[0][amount]"
                                       class="form-control" placeholder="250" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('app.milestone_due_date') }}</label>
                                <input type="date" name="milestones[0][due_date]" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('app.milestone_description') }}</label>
                                <input type="text" name="milestones[0][description]"
                                       class="form-control" placeholder="{{ __('app.milestone_deliver') }}">
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

const milestoneLabel = @json(__('app.milestone_title'));
const removeLabel = @json(__('app.remove_milestone'));
const titleLabel = @json(__('app.milestone_title'));
const amountLabel = @json(__('app.milestone_amount'));
const dueDateLabel = @json(__('app.milestone_due_date'));
const descriptionLabel = @json(__('app.milestone_description'));
const deliverPlaceholder = @json(__('app.milestone_deliver'));

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
                <input type="text" name="milestones[${count}][title]" class="form-control" placeholder="${deliverPlaceholder}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">${amountLabel}</label>
                <input type="number" name="milestones[${count}][amount]" class="form-control" placeholder="250" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">${dueDateLabel}</label>
                <input type="date" name="milestones[${count}][due_date]" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">${descriptionLabel}</label>
                <input type="text" name="milestones[${count}][description]" class="form-control" placeholder="${deliverPlaceholder}">
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