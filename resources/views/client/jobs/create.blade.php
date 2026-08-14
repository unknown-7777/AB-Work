@extends('layouts.dashboard')
@section('title', __('app.post_a_job'))

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="bg-white rounded-3 shadow-sm p-4">
            <h4 class="fw-bold mb-4">{{ __('app.post_a_new_job') }}</h4>

            <form action="{{ route('client.jobs.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ __('app.job_title') }}</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" placeholder="{{ __('app.job_title_placeholder') }}">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ __('app.category') }}</label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">{{ __('app.select_category') }}</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ __('app.description') }}</label>
                    <textarea name="description" rows="6"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="{{ __('app.job_description_placeholder') }}">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">{{ __('app.budget_type') }}</label>
                        <select name="budget_type" class="form-select">
                            <option value="fixed"  {{ old('budget_type') == 'fixed'  ? 'selected' : '' }}>{{ __('app.fixed_price') }}</option>
                            <option value="hourly" {{ old('budget_type') == 'hourly' ? 'selected' : '' }}>{{ __('app.hourly_rate') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">{{ __('app.budget_min') }} ($)</label>
                        <input type="number" name="budget_min"
                               class="form-control @error('budget_min') is-invalid @enderror"
                               value="{{ old('budget_min') }}" placeholder="100">
                        @error('budget_min') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">{{ __('app.budget_max') }} ($)</label>
                        <input type="number" name="budget_max"
                               class="form-control @error('budget_max') is-invalid @enderror"
                               value="{{ old('budget_max') }}" placeholder="500">
                        @error('budget_max') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('app.experience_level') }}</label>
                        <select name="experience_level" class="form-select">
                            <option value="entry"        {{ old('experience_level') == 'entry'        ? 'selected' : '' }}>{{ __('app.entry_level') }}</option>
                            <option value="intermediate" {{ old('experience_level') == 'intermediate' ? 'selected' : '' }}>{{ __('app.intermediate_level') }}</option>
                            <option value="expert"       {{ old('experience_level') == 'expert'       ? 'selected' : '' }}>{{ __('app.expert_level') }}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('app.project_length') }}</label>
                        <select name="project_length" class="form-select">
                            <option value="">{{ __('app.not_sure') }}</option>
                            <option value="short"  {{ old('project_length') == 'short'  ? 'selected' : '' }}>{{ __('app.project_length_short') }}</option>
                            <option value="medium" {{ old('project_length') == 'medium' ? 'selected' : '' }}>{{ __('app.project_length_medium') }}</option>
                            <option value="long"   {{ old('project_length') == 'long'   ? 'selected' : '' }}>{{ __('app.project_length_long') }}</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ __('app.required_skills') }}</label>
                    <input type="text" name="required_skills"
                           class="form-control"
                           value="{{ old('required_skills') }}"
                           placeholder="{{ __('app.skills_placeholder') }}">
                    <small class="text-muted">{{ __('app.skills_help_text') }}</small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">{{ __('app.deadline_optional') }}</label>
                    <input type="date" name="deadline"
                           class="form-control @error('deadline') is-invalid @enderror"
                           value="{{ old('deadline') }}">
                    @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary px-5">
                    <i class="bi bi-send me-2"></i>{{ __('app.post_job') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection