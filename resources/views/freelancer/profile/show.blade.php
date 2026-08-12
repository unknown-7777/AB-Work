@extends('layouts.dashboard')
@section('title', $user->name)

@section('content')
<div class="row g-4">

    <div class="col-lg-4">
        <div class="bg-white rounded-3 shadow-sm p-4 text-center">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=fff&size=80"
                 class="rounded-circle mb-3" width="80" height="80">
            <h4 class="fw-bold">{{ $user->name }}</h4>
            <p class="text-muted mb-2">{{ $user->profile->title ?? 'Freelancer' }}</p>

            @if($user->profile?->availability)
            <span class="badge
                @if($user->profile->availability == 'available') bg-success
                @elseif($user->profile->availability == 'busy') bg-warning text-dark
                @else bg-danger @endif mb-3">
                {{ ucfirst($user->profile->availability) }}
            </span>
            @endif

            <hr>

            @if($user->profile?->location)
            <div class="text-muted small mb-2">
                <i class="bi bi-geo-alt me-1"></i>{{ $user->profile->location }}
            </div>
            @endif

            @if($user->profile?->hourly_rate)
            <div class="text-muted small mb-2">
                <i class="bi bi-clock me-1"></i>${{ number_format($user->profile->hourly_rate) }}/hr
            </div>
            @endif

            @if($user->profile?->website)
            <div class="text-muted small mb-2">
                <i class="bi bi-globe me-1"></i>
                <a href="{{ $user->profile->website }}" target="_blank">Website</a>
            </div>
            @endif

            <div class="text-muted small">
                <i class="bi bi-calendar me-1"></i>
                Member since {{ $user->created_at->format('M Y') }}
            </div>
        </div>
    </div>

    <div class="col-lg-8">

        @if($user->profile?->bio)
        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
            <h5 class="fw-bold mb-3">About</h5>
            <p class="text-muted" style="white-space:pre-line;">{{ $user->profile->bio }}</p>
        </div>
        @endif


        @if($user->profile?->skills)
        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
            <h5 class="fw-bold mb-3">Skills</h5>
            @foreach($user->profile->skills as $skill)
                <span class="badge bg-primary bg-opacity-10 text-primary me-1 mb-1 p-2">
                    {{ $skill }}
                </span>
            @endforeach
        </div>
        @endif

        {{-- Reviews --}}
        <div class="bg-white rounded-3 shadow-sm p-4">
            <h5 class="fw-bold mb-3">
                Reviews
                @if($user->reviewsReceived->count() > 0)
                    <span class="text-warning ms-2">
                        {{ number_format($user->reviewsReceived->avg('rating'), 1) }} ⭐
                    </span>
                    <small class="text-muted">({{ $user->reviewsReceived->count() }})</small>
                @endif
            </h5>

            @forelse($user->reviewsReceived as $review)
            <div class="border-bottom pb-3 mb-3">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->reviewer->name) }}&background=eee&color=333&size=32"
                         class="rounded-circle" width="32" height="32">
                    <div>
                        <div class="fw-semibold small">{{ $review->reviewer->name }}</div>
                        <div class="text-warning small">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $review->rating ? '★' : '☆' }}
                            @endfor
                        </div>
                    </div>
                    <small class="text-muted ms-auto">{{ $review->created_at->diffForHumans() }}</small>
                </div>
                @if($review->comment)
                    <p class="text-muted small mb-0">{{ $review->comment }}</p>
                @endif
            </div>
            @empty
                <p class="text-muted">No reviews yet.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection