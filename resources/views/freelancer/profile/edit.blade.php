@extends('layouts.dashboard')
@section('title', __('app.my_profile'))

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="bg-white rounded-3 shadow-sm p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatarUrl() }}"
                         class="rounded-circle border border-3 border-primary"
                         width="100" height="100"
                         style="object-fit:cover;" id="avatarPreview">
                @else
                    <div id="avatarIconWrapper" style="width:100px;height:100px;position:relative;">
                        <i class="bi bi-person-circle text-primary" id="avatarIcon"
                           style="font-size:100px; line-height:1; display:block;"></i>
                        <img src="" class="rounded-circle border border-3 border-primary d-none"
                             width="100" height="100"
                             style="object-fit:cover;position:absolute;top:0;left:0;" id="avatarPreview">
                    </div>
                @endif
                
                <div>
                    <h4 class="fw-bold mb-0">{{ auth()->user()->name }}</h4>
                    <small class="text-muted">{{ auth()->user()->email }}</small>
                </div>
            </div>

            <form action="{{ route('freelancer.profile.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ __('app.professional_title') }}</label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title', $profile->title) }}"
                           placeholder="{{ __('app.title_placeholder') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ __('app.bio') }}</label>
                    <textarea name="bio" rows="5" class="form-control"
                              placeholder="{{ __('app.bio_placeholder') }}">{{ old('bio', $profile->bio) }}</textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('app.location') }}</label>
                        <input type="text" name="location" class="form-control"
                               value="{{ old('location', $profile->location) }}"
                               placeholder="{{ __('app.location_placeholder') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('app.hourly_rate') }}</label>
                        <input type="number" name="hourly_rate" class="form-control"
                               value="{{ old('hourly_rate', $profile->hourly_rate) }}"
                               placeholder="e.g. 25">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ __('app.skills') }}</label>
                    <input type="text" name="skills" class="form-control"
                           value="{{ old('skills', is_array($profile->skills) ? implode(', ', $profile->skills) : '') }}"
                           placeholder="PHP, Laravel, Vue.js, MySQL">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('app.website') }}</label>
                        <input type="url" name="website" class="form-control"
                               value="{{ old('website', $profile->website) }}"
                               placeholder="https://yourwebsite.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('app.availability') }}</label>
                        <select name="availability" class="form-select">
                            <option value="available"   {{ old('availability', $profile->availability) == 'available'   ? 'selected' : '' }}>{{ __('app.available') }}</option>
                            <option value="busy"        {{ old('availability', $profile->availability) == 'busy'        ? 'selected' : '' }}>{{ __('app.busy') }}</option>
                            <option value="unavailable" {{ old('availability', $profile->availability) == 'unavailable' ? 'selected' : '' }}>{{ __('app.unavailable') }}</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary px-5">
                    <i class="bi bi-save me-2"></i>{{ __('app.save_profile') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection