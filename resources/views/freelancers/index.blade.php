@extends('layouts.dashboard')
@section('title', 'Find Freelancers')

@section('content')
<div class="row g-4">


    <div class="col-lg-3">
        <div class="bg-white rounded-3 shadow-sm p-4 sticky-top" style="top:20px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Filters</h6>
                @if(request()->hasAny(['search','skill','availability','max_rate','sort']))
                    <a href="{{ route('freelancers.index') }}" class="btn btn-sm btn-outline-danger">
                        Clear
                    </a>
                @endif
            </div>

            <form method="GET" id="filterForm">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif


                <div class="mb-3">
                    <label class="form-label fw-semibold small">Skill</label>
                    <select name="skill" class="form-select form-select-sm"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">Any Skill</option>
                        @foreach($allSkills as $skill)
                            <option value="{{ $skill }}"
                                {{ request('skill') == $skill ? 'selected' : '' }}>
                                {{ $skill }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label fw-semibold small">Availability</label>
                    <select name="availability" class="form-select form-select-sm"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">Any</option>
                        <option value="available"   {{ request('availability') == 'available'   ? 'selected' : '' }}>Available</option>
                        <option value="busy"        {{ request('availability') == 'busy'        ? 'selected' : '' }}>Busy</option>
                        <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label fw-semibold small">Max Hourly Rate ($)</label>
                    <input type="number" name="max_rate" class="form-control form-control-sm"
                           placeholder="e.g. 50" value="{{ request('max_rate') }}">
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
                       placeholder="Search by name, title or skill..."
                       value="{{ request('search') }}">
                <button class="btn btn-primary px-4">Search</button>
            </div>
        </form>


        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted small">
                <strong>{{ $freelancers->total() }}</strong> freelancers found
            </div>
            <select class="form-select form-select-sm" style="width:auto;"
                    onchange="window.location='{{ request()->fullUrlWithoutQuery('sort') }}&sort='+this.value">
                <option value="latest" {{ request('sort','latest') == 'latest' ? 'selected' : '' }}>Newest</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated</option>
                <option value="rate_asc" {{ request('sort') == 'rate_asc' ? 'selected' : '' }}>Highest Rate</option>
            </select>
        </div>

        @if($freelancers->isEmpty())
            <div class="bg-white rounded-3 shadow-sm p-5 text-center text-muted">
                <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
                <h5>No freelancers found</h5>
                <p class="small">Try different search terms or filters.</p>
                <a href="{{ route('freelancers.index') }}" class="btn btn-outline-primary btn-sm">Clear Filters</a>
            </div>
        @else
            <div class="row g-3">
                @foreach($freelancers as $freelancer)
                <div class="col-md-6 col-xl-4">
                    <div class="bg-white rounded-3 shadow-sm p-4 h-100 d-flex flex-column"
                         style="transition: transform 0.2s, box-shadow 0.2s;"
                         onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 25px rgba(0,0,0,0.12)'"
                         onmouseout="this.style.transform='';this.style.boxShadow=''">


                        <div class="text-center mb-3">
                            @if($freelancer->avatar)
                                <img src="{{ $freelancer->avatarUrl() }}"
                                     class="rounded-circle mb-2" width="70" height="70"
                                     style="object-fit:cover;">
                            @else
                                <i class="bi bi-person-circle text-primary d-block mb-2"
                                   style="font-size:70px; line-height:1;"></i>
                            @endif
                            <h6 class="fw-bold mb-0">{{ $freelancer->name }}</h6>
                            <small class="text-muted">
                                {{ $freelancer->profile->title ?? 'Freelancer' }}
                            </small>
                        </div>


                        @php
                            $avg = $freelancer->reviewsReceived->avg('rating') ?? 0;
                            $count = $freelancer->reviewsReceived->count();
                        @endphp
                        <div class="text-center mb-2">
                            @if($count > 0)
                                <span class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($avg) ? '★' : '☆' }}
                                    @endfor
                                </span>
                                <small class="text-muted">({{ $count }})</small>
                            @else
                                <small class="text-muted">No reviews yet</small>
                            @endif
                        </div>


                        <!--<div class="d-flex justify-content-center gap-3 mb-3">
                            @if($freelancer->profile?->hourly_rate)
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    ${{ number_format($freelancer->profile->hourly_rate) }}/hr
                                </small>
                            @endif
                            @if($freelancer->profile?->location)
                                <small class="text-muted">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    {{ $freelancer->profile->location }}
                                </small>
                            @endif
                        </div>-->


                        @if($freelancer->profile?->availability)
                        <div class="text-center mb-3">
                            <span class="badge
                                @if($freelancer->profile->availability == 'available') bg-success
                                @elseif($freelancer->profile->availability == 'busy') bg-warning text-dark
                                @else bg-danger @endif">
                                {{ ucfirst($freelancer->profile->availability) }}
                            </span>
                        </div>
                        @endif


                        @if($freelancer->profile?->skills)
                        <div class="d-flex flex-wrap justify-content-center gap-1 mb-3">
                            @foreach(array_slice($freelancer->profile->skills, 0, 3) as $skill)
                                <span class="badge bg-primary bg-opacity-10 text-primary">{{ $skill }}</span>
                            @endforeach
                            @if(count($freelancer->profile->skills) > 3)
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    +{{ count($freelancer->profile->skills) - 3 }}
                                </span>
                            @endif
                        </div>
                        @endif


                        <div class="mt-auto">
                            <a href="{{ route('freelancers.show', $freelancer) }}"
                               class="btn btn-outline-primary btn-sm w-100">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $freelancers->links() }}</div>
        @endif
    </div>
</div>
@endsection