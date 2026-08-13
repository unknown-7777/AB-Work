<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - {{ config('app.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">

    <style>
        body {
            background-color: #f3f4f6 !important;
        }
        .reset-card {
            border: 1px solid #e5e7eb !important;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-sm-10 col-md-5 col-lg-4">
            
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark d-inline-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-briefcase-fill text-primary"></i> {{ config('app.name', 'ABWork') }}
                </h2>
                <p class="text-muted small">Update your account credentials</p>
            </div>

            <div class="card reset-card border-0 shadow-sm bg-white p-4 p-md-4 rounded-3">

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small text-secondary">Email Address</label>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email', $request->email) }}" 
                               class="form-control py-2 rounded-3 @error('email') is-invalid @enderror" 
                               placeholder="name@company.com"
                               required 
                               autofocus 
                               autocomplete="username" />
                        
                        @error('email')
                            <div class="invalid-feedback small fw-medium mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold small text-secondary">New Password</label>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               class="form-control py-2 rounded-3 @error('password') is-invalid @enderror" 
                               placeholder="••••••••"
                               required 
                               autocomplete="new-password" />
                        
                        @error('password')
                            <div class="invalid-feedback small fw-medium mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold small text-secondary">Confirm New Password</label>
                        <input id="password_confirmation" 
                               type="password" 
                               name="password_confirmation" 
                               class="form-control py-2 rounded-3 @error('password_confirmation') is-invalid @enderror" 
                               placeholder="••••••••"
                               required 
                               autocomplete="new-password" />
                        
                        @error('password_confirmation')
                            <div class="invalid-feedback small fw-medium mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">
                        {{ __('Reset Password') }}
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>