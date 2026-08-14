@extends('layouts.dashboard')
@section('title', __('app.leave_review'))

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">

        <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
            <div class="d-flex align-items-center gap-3">
                @if($reviewee->avatar)
                    <img src="{{ $reviewee->avatarUrl() }}"
                         class="rounded-circle" width="56" height="56"
                         style="object-fit:cover;">
                @else
                    <i class="bi bi-person-circle text-primary" style="font-size:56px;"></i>
                @endif
                <div>
                    <div class="text-muted small">{{ __('app.reviewing') }}</div>
                    <h5 class="fw-bold mb-0">{{ $reviewee->name }}</h5>
                    <small class="text-muted">{{ __('app.for') }}: <strong>{{ $job->title }}</strong></small>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3 shadow-sm p-4">
            <h5 class="fw-bold mb-4">{{ __('app.your_review') }}</h5>

            <form action="{{ route('reviews.store', $job) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-semibold">{{ __('app.overall_rating') }} <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3 flex-wrap">
                        @for($i = 1; $i <= 5; $i++)
                        <div>
                            <input type="radio" class="btn-check" name="rating"
                                   id="rating{{ $i }}" value="{{ $i }}"
                                   {{ old('rating') == $i ? 'checked' : '' }} required>
                            <label class="btn btn-outline-warning" for="rating{{ $i }}">
                                {{ $i }} ⭐
                            </label>
                        </div>
                        @endfor
                    </div>
                    @error('rating')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">{{ __('app.detailed_ratings') }} <span class="text-muted fw-normal">{{ __('app.optional') }}</span></label>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small">{{ __('app.communication') }}</label>
                            <select name="communication" class="form-select form-select-sm">
                                <option value="">-</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('communication') == $i ? 'selected' : '' }}>
                                        {{ $i }} ⭐
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">{{ __('app.quality') }}</label>
                            <select name="quality" class="form-select form-select-sm">
                                <option value="">-</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('quality') == $i ? 'selected' : '' }}>
                                        {{ $i }} ⭐
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">{{ __('app.professionalism') }}</label>
                            <select name="professionalism" class="form-select form-select-sm">
                                <option value="">-</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('professionalism') == $i ? 'selected' : '' }}>
                                        {{ $i }} ⭐
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        {{ __('app.comment') }} <span class="text-muted fw-normal">{{ __('app.optional') }}</span>
                    </label>
                    <textarea name="comment" rows="5" class="form-control"
                              placeholder="{{ __('app.share_experience') }}">{{ old('comment') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning px-5 fw-bold">
                        <i class="bi bi-star me-2"></i>{{ __('app.submit_review') }}
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        {{ __('app.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection