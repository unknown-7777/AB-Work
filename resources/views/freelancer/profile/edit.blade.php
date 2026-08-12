@extends('layouts.dashboard')
@section('title', 'My Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="bg-white rounded-3 shadow-sm p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <i class="bi bi-person-circle text-primary" style="font-size: 36px; line-height: 1;"></i>
                <div>
                    <h4 class="fw-bold mb-0">{{ auth()->user()->name }}</h4>
                    <small class="text-muted">{{ auth()->user()->email }}</small>
                </div>
            </div>

            <form action="{{ route('freelancer.profile.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Professional Title</label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title', $profile->title) }}"
                           placeholder="e.g. Full Stack Laravel Developer">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Bio</label>
                    <textarea name="bio" rows="5" class="form-control"
                              placeholder="Tell clients about yourself...">{{ old('bio', $profile->bio) }}</textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Location</label>
                        <input type="text" name="location" class="form-control"
                               value="{{ old('location', $profile->location) }}"
                               placeholder="e.g. Ashgabat, Turkmenistan">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Hourly Rate ($)</label>
                        <input type="number" name="hourly_rate" class="form-control"
                               value="{{ old('hourly_rate', $profile->hourly_rate) }}"
                               placeholder="e.g. 25">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Skills</label>
                    <input type="text" name="skills" class="form-control"
                           value="{{ old('skills', is_array($profile->skills) ? implode(', ', $profile->skills) : '') }}"
                           placeholder="PHP, Laravel, Vue.js, MySQL">
                    <small class="text-muted">Separate with commas</small>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Website</label>
                        <input type="url" name="website" class="form-control"
                               value="{{ old('website', $profile->website) }}"
                               placeholder="https://yourwebsite.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Availability</label>
                        <select name="availability" class="form-select">
                            <option value="available"   {{ old('availability', $profile->availability) == 'available'   ? 'selected' : '' }}>Available</option>
                            <option value="busy"        {{ old('availability', $profile->availability) == 'busy'        ? 'selected' : '' }}>Busy</option>
                            <option value="unavailable" {{ old('availability', $profile->availability) == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary px-5">
                    <i class="bi bi-save me-2"></i>Save Profile
                </button>
            </form>
        </div>
    </div>
</div>
@endsection