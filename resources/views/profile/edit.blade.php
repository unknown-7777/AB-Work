@extends('layouts.dashboard')
@section('title', 'Manage profile')

@section('content')

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-light">
        <div>
            <h2 class="fw-bold text-dark mb-1 fs-4">{{ __('Profile Settings') }}</h2>
            <p class="text-muted small mb-0">Update your account information, security credentials, and platform visibility parameters</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-8">


            <div class="card border-0 shadow-sm bg-white p-4 rounded-3 mb-4">
                <h5 class="fw-bold mb-4">Profile Picture</h5>
                <div class="d-flex align-items-center gap-4">


                    <div class="position-relative">
                        @if($user->avatar)
                            <img src="{{ $user->avatarUrl() }}"
                                 class="rounded-circle border border-3 border-primary"
                                 width="90" height="90"
                                 style="object-fit:cover;" id="avatarPreview">
                                     @else
                                         <div id="avatarIconWrapper" style="width:90px;height:90px;position:relative;">
                                             <i class="bi bi-person-circle text-primary" id="avatarIcon"
                                                style="font-size:90px; line-height:90px; display:block;"></i>
                                             <img src="" class="rounded-circle border border-3 border-primary d-none"
                                                  width="90" height="90"
                                                  style="object-fit:cover;position:absolute;top:0;left:0;" id="avatarPreview">
                                         </div>
                                     @endif


                        <label for="avatarInput"
                               class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                               style="width:30px;height:30px;cursor:pointer;" title="Change photo">
                            <i class="bi bi-camera-fill" style="font-size:0.75rem;"></i>
                        </label>
                    </div>


                    <div>
                        <div class="fw-bold fs-6">{{ auth()->user()->name }}</div>
                        <div class="text-muted small mb-3">{{ ucfirst(auth()->user()->role) }}</div>

                        <form action="{{ route('avatar.update') }}" method="POST"
                              enctype="multipart/form-data" id="avatarForm">
                            @csrf
                            <input type="file" id="avatarInput" name="avatar"
                                   class="d-none" accept="image/jpeg,image/png,image/webp">
                        </form>

                        <div class="d-flex gap-2">
                            <label for="avatarInput" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-upload me-1"></i>Upload Photo
                            </label>
                            @if($user->avatar)
                            <form action="{{ route('avatar.destroy') }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Remove profile photo?')">
                                    <i class="bi bi-trash me-1"></i>Remove
                                </button>
                            </form>
                            @endif
                        </div>
                        <small class="text-muted d-block mt-2">JPG, PNG or WebP. Max 2MB.</small>
                    </div>
                </div>
            </div>


            <div class="card border-0 shadow-sm bg-white p-4 rounded-3 mb-4">
                <div class="w-100" style="max-width: 600px;">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>


            <div class="card border-0 shadow-sm bg-white p-4 rounded-3 mb-4">
                <div class="w-100" style="max-width: 600px;">
                    @include('profile.partials.update-password-form')
                </div>
            </div>


            <div class="card border border-danger border-opacity-25 shadow-sm bg-white p-4 rounded-3">
                <div class="w-100" style="max-width: 600px;">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('avatarInput').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {

            const preview = document.getElementById('avatarPreview');
            const icon = document.getElementById('avatarIcon');

            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if (icon) icon.classList.add('d-none');
        };
        reader.readAsDataURL(this.files[0]);


        document.getElementById('avatarForm').submit();
    }
});
</script>
@endpush
@endsection