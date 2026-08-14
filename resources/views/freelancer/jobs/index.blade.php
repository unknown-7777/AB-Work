@extends('layouts.dashboard')
@section('title', __('app.find_jobs'))

@section('content')
<div class="row g-4">

    {{-- Sidebar Filters --}}
    <div class="col-lg-3">
        <div class="bg-white rounded-3 shadow-sm p-4 sticky-top" style="top:20px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">{{ __('app.filters') }}</h6>
                @if(request()->hasAny(['search','category','budget_type','budget_min','budget_max','experience','project_length','skill','sort']))
                    <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-sm btn-outline-danger">
                        {{ __('app.clear_all') }}
                    </a>
                @endif
            </div>

            <form method="GET" id="filterForm">

                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                {{-- Category Filter --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold small">{{ __('app.category') }}</label>
                    <select name="category" class="form-select form-select-sm"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">{{ __('app.all_categories') }}</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Budget Type --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold small">{{ __('app.budget_type') }}</label>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="budget_type"
                                   value="" id="bt_all"
                                   {{ !request('budget_type') ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label small" for="bt_all">{{ __('app.any_budget') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="budget_type"
                                   value="fixed" id="bt_fixed"
                                   {{ request('budget_type') == 'fixed' ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label small" for="bt_fixed">{{ __('app.fixed_price') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="budget_type"
                                   value="hourly" id="bt_hourly"
                                   {{ request('budget_type') == 'hourly' ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label small" for="bt_hourly">{{ __('app.hourly_rate') }}</label>
                        </div>
                    </div>
                </div>

                {{-- Budget Range --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold small">{{ __('app.budget_range') }}</label>
                    <div class="d-flex gap-2">
                        <input type="number" name="budget_min" class="form-control form-control-sm"
                               placeholder="{{ __('app.budget_min') }}" value="{{ request('budget_min') }}">
                        <input type="number" name="budget_max" class="form-control form-control-sm"
                               placeholder="{{ __('app.budget_max') }}" value="{{ request('budget_max') }}">
                    </div>
                </div>

                {{-- Experience Level --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold small">{{ __('app.experience_level') }}</label>
                    <select name="experience" class="form-select form-select-sm"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">{{ __('app.any_level') }}</option>
                        <option value="entry"        {{ request('experience') == 'entry'        ? 'selected' : '' }}>{{ __('app.entry_level') }}</option>
                        <option value="intermediate" {{ request('experience') == 'intermediate' ? 'selected' : '' }}>{{ __('app.intermediate_level') }}</option>
                        <option value="expert"       {{ request('experience') == 'expert'       ? 'selected' : '' }}>{{ __('app.expert_level') }}</option>
                    </select>
                </div>

                {{-- Project Length --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold small">{{ __('app.project_length') }}</label>
                    <select name="project_length" class="form-select form-select-sm"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">{{ __('app.any_length') }}</option>
                        <option value="short"  {{ request('project_length') == 'short'  ? 'selected' : '' }}>{{ __('app.short_project') }}</option>
                        <option value="medium" {{ request('project_length') == 'medium' ? 'selected' : '' }}>{{ __('app.medium_project') }}</option>
                        <option value="long"   {{ request('project_length') == 'long'   ? 'selected' : '' }}>{{ __('app.long_project') }}</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-sm">
                    <i class="bi bi-funnel me-1"></i>{{ __('app.apply_filters') }}
                </button>
            </form>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="col-lg-9">

        {{-- Search Form --}}
        <form method="GET" class="mb-4">
            @foreach(request()->except('search') as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0"
                       placeholder="{{ __('app.search_jobs') }}"
                       value="{{ request('search') }}">
                <button class="btn btn-primary px-4">{{ __('app.search') }}</button>
            </div>
        </form>

        {{-- Results Header & Sorting --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted small">
                {{ __('app.jobs_found', ['count' => $jobs->total()]) }}
                @if(request('search'))
                    for "<strong>{{ request('search') }}</strong>"
                @endif
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">{{ __('app.sort_by') }}</span>
                <select class="form-select form-select-sm" style="width:auto;"
                        onchange="window.location='{{ request()->fullUrlWithoutQuery('sort') }}&sort='+this.value">
                    <option value="latest"      {{ request('sort','latest') == 'latest'      ? 'selected' : '' }}>{{ __('app.latest') }}</option>
                    <option value="oldest"      {{ request('sort') == 'oldest'      ? 'selected' : '' }}>{{ __('app.oldest') }}</option>
                    <option value="budget_desc" {{ request('sort') == 'budget_desc' ? 'selected' : '' }}>{{ __('app.budget_high_low') }}</option>
                    <option value="budget_asc"  {{ request('sort') == 'budget_asc'  ? 'selected' : '' }}>{{ __('app.budget_low_high') }}</option>
                    <option value="bids_asc"    {{ request('sort') == 'bids_asc'    ? 'selected' : '' }}>{{ __('app.least_bids') }}</option>
                </select>
            </div>
        </div>

        {{-- Active Filter Badges --}}
        @if(request()->hasAny(['category','budget_type','budget_min','budget_max','experience','project_length']))
        <div class="d-flex flex-wrap gap-2 mb-3">
            @if(request('category'))
                @php $cat = $categories->find(request('category')); @endphp
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                    {{ $cat->name ?? __('app.category') }}
                    <a href="{{ request()->fullUrlWithoutQuery('category') }}" class="text-primary ms-1">×</a>
                </span>
            @endif
            @if(request('budget_type'))
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                    {{ request('budget_type') == 'fixed' ? __('app.fixed_price') : __('app.hourly_rate') }}
                    <a href="{{ request()->fullUrlWithoutQuery('budget_type') }}" class="text-primary ms-1">×</a>
                </span>
            @endif
            @if(request('experience'))
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                    {{ __('app.' . request('experience') . '_level') }}
                    <a href="{{ request()->fullUrlWithoutQuery('experience') }}" class="text-primary ms-1">×</a>
                </span>
            @endif
            @if(request('project_length'))
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                    {{ __('app.' . request('project_length') . '_project') }}
                    <a href="{{ request()->fullUrlWithoutQuery('project_length') }}" class="text-primary ms-1">×</a>
                </span>
            @endif
        </div>
        @endif

        {{-- Job Feed --}}
        @if($jobs->isEmpty())
            <div class="bg-white rounded-3 shadow-sm p-5 text-center text-muted">
                <i class="bi bi-search fs-1 d-block mb-3 opacity-25"></i>
                <h5>{{ __('app.no_jobs_found') }}</h5>
                <p class="small">{{ __('app.try_filters') }}</p>
                <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-primary btn-sm">
                    {{ __('app.clear_filters') }}
                </a>
            </div>
        @else
            @foreach($jobs as $job)
            <div class="bg-white rounded-3 shadow-sm p-4 mb-3 border border-transparent"
                 style="transition: border 0.2s;"
                 onmouseover="this.style.borderColor='#2563eb'"
                 onmouseout="this.style.borderColor='transparent'">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h5 class="fw-bold mb-0">
                                <a href="{{ route('freelancer.jobs.show', $job) }}"
                                   class="text-decoration-none text-dark">
                                    {{ $job->title }}
                                </a>
                            </h5>
                            @if($job->is_featured)
                                <span class="badge bg-warning text-dark">{{ __('app.featured') }}</span>
                            @endif
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-tag me-1"></i>{{ $job->category->name ?? __('app.no_data') }} ·
                            <i class="bi bi-person me-1"></i>{{ $job->client->name }} ·
                            <i class="bi bi-clock me-1"></i>{{ $job->created_at->diffForHumans() }}
                        </small>
                        <p class="mt-2 mb-2 text-muted small"
                           style="white-space:pre-wrap; word-wrap:break-word;">
                            {{ Str::limit($job->description, 200) }}
                        </p>
                        @if($job->required_skills)
                            <div class="d-flex flex-wrap gap-1 mt-2">
                                @foreach($job->required_skills as $skill)
                                    <a href="{{ route('freelancer.jobs.index', ['skill' => $skill]) }}"
                                       class="badge bg-primary bg-opacity-10 text-primary text-decoration-none">
                                        {{ $skill }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="text-end ms-4" style="min-width:130px;">
                        <div class="fw-bold text-success fs-5">
                            ${{ number_format($job->budget_min) }}
                            @if($job->budget_max)
                                – ${{ number_format($job->budget_max) }}
                            @endif
                        </div>
                        <small class="text-muted">
                            {{ $job->budget_type == 'hourly' ? __('app.hourly_rate') : __('app.fixed_price') }}
                        </small>
                        <div class="mt-2 text-muted small">
                            <i class="bi bi-people me-1"></i>{{ __('app.bids_count', ['count' => $job->bids_count]) }}
                        </div>
                        <div class="mt-1">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                {{ __('app.' . $job->experience_level) }}
                            </span>
                        </div>
                        <a href="{{ route('freelancer.jobs.show', $job) }}"
                           class="btn btn-outline-primary btn-sm mt-2 w-100">
                            {{ __('app.view_job') }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            {{ $jobs->links() }}
        @endif
    </div>
</div>
@endsection