@extends('layouts.dashboard')
@section('title', 'Post a Job')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="bg-white rounded-3 shadow-sm p-4">
            <h4 class="fw-bold mb-4">Post a New Job</h4>

            <form action="{{ route('client.jobs.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Job Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" placeholder="e.g. Build a Laravel REST API">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Category</label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" rows="6"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Describe your project in detail...">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Budget Type</label>
                        <select name="budget_type" class="form-select">
                            <option value="fixed"  {{ old('budget_type') == 'fixed'  ? 'selected' : '' }}>Fixed Price</option>
                            <option value="hourly" {{ old('budget_type') == 'hourly' ? 'selected' : '' }}>Hourly Rate</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Budget Min ($)</label>
                        <input type="number" name="budget_min"
                               class="form-control @error('budget_min') is-invalid @enderror"
                               value="{{ old('budget_min') }}" placeholder="100">
                        @error('budget_min') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Budget Max ($)</label>
                        <input type="number" name="budget_max"
                               class="form-control @error('budget_max') is-invalid @enderror"
                               value="{{ old('budget_max') }}" placeholder="500">
                        @error('budget_max') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Experience Level</label>
                        <select name="experience_level" class="form-select">
                            <option value="entry"        {{ old('experience_level') == 'entry'        ? 'selected' : '' }}>Entry</option>
                            <option value="intermediate" {{ old('experience_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="expert"       {{ old('experience_level') == 'expert'       ? 'selected' : '' }}>Expert</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Project Length</label>
                        <select name="project_length" class="form-select">
                            <option value="">Not sure</option>
                            <option value="short"  {{ old('project_length') == 'short'  ? 'selected' : '' }}>Short (under 1 month)</option>
                            <option value="medium" {{ old('project_length') == 'medium' ? 'selected' : '' }}>Medium (1–3 months)</option>
                            <option value="long"   {{ old('project_length') == 'long'   ? 'selected' : '' }}>Long (3+ months)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Required Skills</label>
                    <input type="text" name="required_skills"
                           class="form-control"
                           value="{{ old('required_skills') }}"
                           placeholder="PHP, Laravel, MySQL, Vue.js">
                    <small class="text-muted">Separate skills with commas</small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Deadline (optional)</label>
                    <input type="date" name="deadline"
                           class="form-control @error('deadline') is-invalid @enderror"
                           value="{{ old('deadline') }}">
                    @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary px-5">
                    <i class="bi bi-send me-2"></i>Post Job
                </button>
            </form>
        </div>
    </div>
</div>
@endsection