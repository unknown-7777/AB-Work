<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email - {{ config('app.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">

    <style>
        body {
            background-color: #f3f4f6 !important;
        }
        .verify-card {
            border: 1px solid #e5e7eb !important;
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
                <p class="text-muted small">Verify your email address</p>
            </div>

            <div class="card verify-card border-0 shadow-sm bg-white p-4 p-md-4 rounded-3">

                <div class="text-muted small mb-3">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success small py-2 rounded-3 mb-4" role="alert">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div class="text-center pt-3 border-top border-light">
                        <button type="submit" class="btn btn-link p-0 text-decoration-none text-danger fw-semibold small">
                            {{ __('Log Out') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>