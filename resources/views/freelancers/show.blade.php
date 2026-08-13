@extends('layouts.dashboard')
@section('title', $user->name)

@section('content')
<div class="row g-4">


    <div class="col-lg-4">
        <div class="bg-white rounded-3 shadow-sm p-4 text-center mb-4">
            @if($user->avatar)
                <img src="{{ $user->avatarUrl() }}"
                     class="rounded-circle mb-3 border border-3 border-primary"
                     width="100" height="100" style="object-fit:cover;">
            @else
                <i class="bi bi-person-circle text-primary d-block mb-3"
                   style="font-size:100px; line-height:1;"></i>
            @endif

            <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
            <p class="text-muted mb-2">{{ $user->profile->title ?? 'Freelancer' }}</p>

            
            @if($user->profile?->availability)
            <span class="badge mb-3
                @if($user->profile->availability == 'available') bg-success
                @elseif($user->profile->availability == 'busy') bg-warning text-dark
                @else bg-danger @endif">
                {{ ucfirst($user->profile->availability) }}
            </span>
            @endif


            @php
                $avg   = $user->reviewsReceived->avg('rating') ?? 0;
                $count = $user->reviewsReceived->count();
            @endphp
            @if($count > 0)
            <div class="mb-3">
                <span class="text-warning fs-5">
                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= round($avg) ? '★' : '☆' }}
                    @endfor
                </span>
                <div class="text-muted small">
                    {{ number_format($avg, 1) }} / 5 · {{ $count }} reviews
                </div>
            </div>
            @endif

            <hr>


            @if($user->profile?->location)
            <div class="text-muted small mb-2">
                <i class="bi bi-geo-alt me-1"></i>{{ $user->profile->location }}
            </div>
            @endif

            @if($user->profile?->hourly_rate)
            <div class="text-muted small mb-2">
                <i class="bi bi-clock me-1"></i>
                ${{ number_format($user->profile->hourly_rate) }}/hr
            </div>
            @endif

            @if($user->profile?->website)
            <div class="text-muted small mb-2">
                <i class="bi bi-globe me-1"></i>
                <a href="{{ $user->profile->website }}" target="_blank">Website</a>
            </div>
            @endif

            <div class="text-muted small mb-3">
                <i class="bi bi-calendar me-1"></i>
                Member since {{ $user->created_at->format('M Y') }}
            </div>

            <div class="text-muted small mb-3">
                <i class="bi bi-check-circle me-1 text-success"></i>
                {{ $completedJobs }} jobs completed
            </div>


            @if(auth()->user()->isClient())
            <a href="{{ route('client.jobs.create') }}" class="btn btn-primary w-100 mb-2">
                <i class="bi bi-briefcase me-2"></i>Post a Job
            </a>
            @endif
        </div>
    </div>

    <div class="col-lg-8">

      @if($user->profile?->bio)
        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
            <h5 class="fw-bold mb-3">About</h5>
            <p class="text-muted" style="white-space:pre-line; word-wrap:break-word;">
                {{ $user->profile->bio }}
            </p>
        </div>
        @endif


        @if($user->profile?->skills)
        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
            <h5 class="fw-bold mb-3">Skills</h5>
            <div class="d-flex flex-wrap gap-2">
                @foreach($user->profile->skills as $skill)
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 fs-6">
                        {{ $skill }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif


        <div class="bg-white rounded-3 shadow-sm p-4">
            <h5 class="fw-bold mb-4">
                Reviews
                @if($count > 0)
                    <span class="text-warning ms-2 fs-6">
                        {{ number_format($avg, 1) }} ⭐
                    </span>
                    <small class="text-muted">({{ $count }})</small>
                @endif
            </h5>

            @forelse($user->reviewsReceived as $review)
            <div class="border-bottom pb-3 mb-3">
                <div class="d-flex align-items-center gap-2 mb-2">
                    @if($review->reviewer->avatar)
                        <img src="{{ $review->reviewer->avatarUrl() }}"
                             class="rounded-circle" width="36" height="36"
                             style="object-fit:cover;">
                    @else
                        <i class="bi bi-person-circle text-primary" style="font-size:36px;"></i>
                    @endif
                    <div>
                        <div class="fw-semibold small">{{ $review->reviewer->name }}</div>
                        <div class="text-warning small">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $review->rating ? '★' : '☆' }}
                            @endfor
                            <span class="text-muted ms-1">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                @if($review->comment)
                    <p class="text-muted small mb-2">{{ $review->comment }}</p>
                @endif


                @if($review->communication || $review->quality || $review->professionalism)
                <div class="d-flex gap-3 flex-wrap">
                    @if($review->communication)
                        <small class="text-muted">
                            Communication: <strong>{{ $review->communication }}/5</strong>
                        </small>
                    @endif
                    @if($review->quality)
                        <small class="text-muted">
                            Quality: <strong>{{ $review->quality }}/5</strong>
                        </small>
                    @endif
                    @if($review->professionalism)
                        <small class="text-muted">
                            Professionalism: <strong>{{ $review->professionalism }}/5</strong>
                        </small>
                    @endif
                </div>
                @endif
            </div>
            @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-star fs-1 d-block mb-2 opacity-25"></i>
                    <p>No reviews yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection