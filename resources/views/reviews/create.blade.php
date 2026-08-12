@extends('layouts.dashboard')
@section('title', 'Leave a Review')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="bg-white rounded-3 shadow-sm p-4">
            <h4 class="fw-bold mb-1">Leave a Review</h4>
            <p class="text-muted mb-4">
                Reviewing: <strong>{{ $reviewee->name }}</strong>
                for job: <strong>{{ $job->title }}</strong>
            </p>

            <form action="{{ route('reviews.store', $job) }}" method="POST">
                @csrf


                <div class="mb-4">
                    <label class="form-label fw-semibold">Overall Rating *</label>
                    <div class="d-flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio"
                                   name="rating" value="{{ $i }}"
                                   id="rating{{ $i }}"
                                   {{ old('rating') == $i ? 'checked' : '' }} required>
                            <label class="form-check-label" for="rating{{ $i }}">
                                {{ $i }} ⭐
                            </label>
                        </div>
                        @endfor
                    </div>
                    @error('rating')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>


                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Communication</label>
                        <select name="communication" class="form-select">
                            <option value="">Select</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('communication') == $i ? 'selected' : '' }}>
                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Quality of Work</label>
                        <select name="quality" class="form-select">
                            <option value="">Select</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('quality') == $i ? 'selected' : '' }}>
                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>


                <div class="mb-4">
                    <label class="form-label fw-semibold">Comment</label>
                    <textarea name="comment" rows="4" class="form-control"
                              placeholder="Share your experience...">{{ old('comment') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary px-5">
                    <i class="bi bi-star me-2"></i>Submit Review
                </button>
            </form>
        </div>
    </div>
</div>
@endsection