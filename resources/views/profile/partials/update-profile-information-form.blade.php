<section>
    <header class="mb-4">
        <h3 class="h5 fw-bold text-dark">
            {{ __('app.profile_info') }}
        </h3>
        <p class="text-muted small">
            {{ __('app.profile_info_desc') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold small text-secondary">{{ __('app.name') }}</label>
            <input id="name" 
                   type="text" 
                   name="name" 
                   value="{{ old('name', $user->name) }}" 
                   class="form-control py-2 rounded-3 @error('name') is-invalid @enderror" 
                   placeholder="John Doe"
                   required 
                   autofocus 
                   autocomplete="name" />
            
            @error('name')
                <div class="invalid-feedback small fw-medium mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="form-label fw-semibold small text-secondary">{{ __('app.email') }}</label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email', $user->email) }}" 
                   class="form-control py-2 rounded-3 @error('email') is-invalid @enderror" 
                   placeholder="name@example.com"
                   required 
                   autocomplete="username" />
            
            @error('email')
                <div class="invalid-feedback small fw-medium mt-1">
                    {{ $message }}
                </div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-light rounded-3 border">
                    <p class="small text-dark mb-2">
                        {{ __('app.email_unverified') }}
                    </p>
                    <button form="send-verification" type="submit" class="btn btn-link p-0 small fw-semibold text-primary text-decoration-none">
                        {{ __('app.resend_verification') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success small py-2 rounded-3 mt-2 mb-0" role="alert">
                            {{ __('app.verification_link_sent') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary py-2 px-4 rounded-3 fw-semibold small">
                {{ __('app.save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-success small fw-medium d-inline-flex align-items-center gap-1 opacity-75" id="profile-status-toast">
                    <i class="bi bi-check-circle-fill"></i> {{ __('app.saved') }}
                </span>
                <script>
                    setTimeout(() => {
                        const toast = document.getElementById('profile-status-toast');
                        if (toast) toast.style.display = 'none';
                    }, 2000);
                </script>
            @endif
        </div>
    </form>
</section>