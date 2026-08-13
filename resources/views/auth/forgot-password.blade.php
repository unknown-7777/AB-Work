<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password - {{ config('app.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">

    <style>
        body {
            background-color: #f3f4f6 !important;
        }
        .forgot-card {
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
                <p class="text-muted small">Reset your workspace password</p>
            </div>

            <div class="card forgot-card border-0 shadow-sm bg-white p-4 p-md-4 rounded-3">

                <div class="text-muted small mb-4">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                @if (session('status'))
                    <div class="alert alert-success small py-2 rounded-3 mb-4" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold small text-secondary">Email Address</label>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               class="form-control py-2 rounded-3 @error('email') is-invalid @enderror" 
                               placeholder="name@company.com"
                               required 
                               autofocus />
                        
                        @error('email')
                            <div class="invalid-feedback small fw-medium mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </form>

                <div class="text-center mt-3 pt-3 border-top border-light">
                    <a href="{{ route('login') }}" class="text-decoration-none text-primary fw-semibold small">
                        Back to Sign In
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>