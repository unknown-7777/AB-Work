<section>
    <header class="mb-4">
        <h3 class="h5 fw-bold text-dark">
            {{ __('app.update_password') }}
        </h3>
        <p class="text-muted small">
            {{ __('app.update_password_desc') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label fw-semibold small text-secondary">{{ __('app.current_password') }}</label>
            <input id="update_password_current_password" 
                   name="current_password" 
                   type="password" 
                   class="form-control py-2 rounded-3 @error('current_password', 'updatePassword') is-invalid @enderror" 
                   placeholder="••••••••"
                   autocomplete="current-password" />
            
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback small fw-medium mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label fw-semibold small text-secondary">{{ __('app.new_password') }}</label>
            <input id="update_password_password" 
                   name="password" 
                   type="password" 
                   class="form-control py-2 rounded-3 @error('password', 'updatePassword') is-invalid @enderror" 
                   placeholder="••••••••"
                   autocomplete="new-password" />
            
            @error('password', 'updatePassword')
                <div class="invalid-feedback small fw-medium mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation" class="form-label fw-semibold small text-secondary">{{ __('app.confirm_password') }}</label>
            <input id="update_password_password_confirmation" 
                   name="password_confirmation" 
                   type="password" 
                   class="form-control py-2 rounded-3 @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                   placeholder="••••••••"
                   autocomplete="new-password" />
            
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback small fw-medium mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary py-2 px-4 rounded-3 fw-semibold small">
                {{ __('app.save') }}
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-success small fw-medium d-inline-flex align-items-center gap-1 opacity-75" id="password-status-toast">
                    <i class="bi bi-check-circle-fill"></i> {{ __('app.saved') }}
                </span>
                <script>
                    setTimeout(() => {
                        const toast = document.getElementById('password-status-toast');
                        if (toast) toast.style.display = 'none';
                    }, 2000);
                </script>
            @endif
        </div>
    </form>
</section>