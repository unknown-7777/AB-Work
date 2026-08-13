<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirm Password - {{ config('app.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">

    <style>
        body {
            background-color: #f3f4f6 !important;
        }
        .confirm-card {
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
                <p class="text-muted small">Security Check</p>
            </div>

            <div class="card confirm-card border-0 shadow-sm bg-white p-4 p-md-4 rounded-3">

                <div class="text-muted small mb-4">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </div>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold small text-secondary">Password</label>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               class="form-control py-2 rounded-3 @error('password') is-invalid @enderror" 
                               placeholder="••••••••"
                               required 
                               autocomplete="current-password" 
                               autofocus />
                        
                        @error('password')
                            <div class="invalid-feedback small fw-medium mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">
                        {{ __('Confirm') }}
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>