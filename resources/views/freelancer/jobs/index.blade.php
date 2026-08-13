@extends('layouts.dashboard')
@section('title', 'Find Jobs')

@section('content')
<div class="row g-4">


    <div class="col-lg-3">
        <div class="bg-white rounded-3 shadow-sm p-4 sticky-top" style="top:20px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Filters</h6>
                @if(request()->hasAny(['search','category','budget_type','budget_min','budget_max','experience','project_length','skill','sort']))
                    <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-sm btn-outline-danger">
                        Clear All
                    </a>
                @endif
            </div>

            <form method="GET" id="filterForm">

                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif


                <div class="mb-3">
                    <label class="form-label fw-semibold small">Category</label>
                    <select name="category" class="form-select form-select-sm"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label fw-semibold small">Budget Type</label>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="budget_type"
                                   value="" id="bt_all"
                                   {{ !request('budget_type') ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label small" for="bt_all">All</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="budget_type"
                                   value="fixed" id="bt_fixed"
                                   {{ request('budget_type') == 'fixed' ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label small" for="bt_fixed">Fixed Price</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="budget_type"
                                   value="hourly" id="bt_hourly"
                                   {{ request('budget_type') == 'hourly' ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label small" for="bt_hourly">Hourly Rate</label>
                        </div>
                    </div>
                </div>


                <div class="mb-3">
                    <label class="form-label fw-semibold small">Budget Range ($)</label>
                    <div class="d-flex gap-2">
                        <input type="number" name="budget_min" class="form-control form-control-sm"
                               placeholder="Min" value="{{ request('budget_min') }}">
                        <input type="number" name="budget_max" class="form-control form-control-sm"
                               placeholder="Max" value="{{ request('budget_max') }}">
                    </div>
                </div>


                <div class="mb-3">
                    <label class="form-label fw-semibold small">Experience Level</label>
                    <select name="experience" class="form-select form-select-sm"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">Any Level</option>
                        <option value="entry"        {{ request('experience') == 'entry'        ? 'selected' : '' }}>Entry</option>
                        <option value="intermediate" {{ request('experience') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="expert"       {{ request('experience') == 'expert'       ? 'selected' : '' }}>Expert</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label fw-semibold small">Project Length</label>
                    <select name="project_length" class="form-select form-select-sm"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">Any Length</option>
                        <option value="short"  {{ request('project_length') == 'short'  ? 'selected' : '' }}>Short (&lt;1 month)</option>
                        <option value="medium" {{ request('project_length') == 'medium' ? 'selected' : '' }}>Medium (1–3 months)</option>
                        <option value="long"   {{ request('project_length') == 'long'   ? 'selected' : '' }}>Long (3+ months)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-sm">
                    <i class="bi bi-funnel me-1"></i>Apply Filters
                </button>
            </form>
        </div>
    </div>


    <div class="col-lg-9">


        <form method="GET" class="mb-4">

            @foreach(request()->except('search') as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0"
                       placeholder="Search jobs by title or keyword..."
                       value="{{ request('search') }}">
                <button class="btn btn-primary px-4">Search</button>
            </div>
        </form>


        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted small">
                <strong>{{ $jobs->total() }}</strong> jobs found
                @if(request('search'))
                    for "<strong>{{ request('search') }}</strong>"
                @endif
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">Sort by:</span>
                <select class="form-select form-select-sm" style="width:auto;"
                        onchange="window.location='{{ request()->fullUrlWithoutQuery('sort') }}&sort='+this.value">
                    <option value="latest"      {{ request('sort','latest') == 'latest'      ? 'selected' : '' }}>Latest</option>
                    <option value="oldest"      {{ request('sort') == 'oldest'      ? 'selected' : '' }}>Oldest</option>
                    <option value="budget_desc" {{ request('sort') == 'budget_desc' ? 'selected' : '' }}>Budget High-Low</option>
                    <option value="budget_asc"  {{ request('sort') == 'budget_asc'  ? 'selected' : '' }}>Budget Low-High</option>
                    <option value="bids_asc"    {{ request('sort') == 'bids_asc'    ? 'selected' : '' }}>Least Bids</option>
                </select>
            </div>
        </div>


        @if(request()->hasAny(['category','budget_type','budget_min','budget_max','experience','project_length']))
        <div class="d-flex flex-wrap gap-2 mb-3">
            @if(request('category'))
                @php $cat = $categories->find(request('category')); @endphp
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                    {{ $cat->name ?? 'Category' }}
                    <a href="{{ request()->fullUrlWithoutQuery('category') }}" class="text-primary ms-1">×</a>
                </span>
            @endif
            @if(request('budget_type'))
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                    {{ ucfirst(request('budget_type')) }}
                    <a href="{{ request()->fullUrlWithoutQuery('budget_type') }}" class="text-primary ms-1">×</a>
                </span>
            @endif
            @if(request('experience'))
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                    {{ ucfirst(request('experience')) }} level
                    <a href="{{ request()->fullUrlWithoutQuery('experience') }}" class="text-primary ms-1">×</a>
                </span>
            @endif
            @if(request('project_length'))
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                    {{ ucfirst(request('project_length')) }} project
                    <a href="{{ request()->fullUrlWithoutQuery('project_length') }}" class="text-primary ms-1">×</a>
                </span>
            @endif
        </div>
        @endif


        @if($jobs->isEmpty())
            <div class="bg-white rounded-3 shadow-sm p-5 text-center text-muted">
                <i class="bi bi-search fs-1 d-block mb-3 opacity-25"></i>
                <h5>No jobs found</h5>
                <p class="small">Try adjusting your filters or search terms.</p>
                <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-primary btn-sm">
                    Clear Filters
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
                                <span class="badge bg-warning text-dark">Featured</span>
                            @endif
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-tag me-1"></i>{{ $job->category->name ?? 'N/A' }} ·
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
                        <small class="text-muted">{{ ucfirst($job->budget_type) }}</small>
                        <div class="mt-2 text-muted small">
                            <i class="bi bi-people me-1"></i>{{ $job->bids_count }} bids
                        </div>
                        <div class="mt-1">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                {{ ucfirst($job->experience_level) }}
                            </span>
                        </div>
                        <a href="{{ route('freelancer.jobs.show', $job) }}"
                           class="btn btn-outline-primary btn-sm mt-2 w-100">
                            View Job
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