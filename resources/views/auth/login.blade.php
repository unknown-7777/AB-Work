<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">   
    <style>
        body {
            background-color: #f8fafc; /* Matches your light dashboard grey background */
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
        <div class="col-md-5 col-lg-4">
            

            <div class="text-center mb-4">
                <a href="/" class="text-decoration-none text-dark fw-bold fs-3 d-inline-flex align-items-center gap-2">
                    <i class="bi bi-briefcase-fill text-primary"></i> {{ config('app.name', 'ABWork') }}
                </a>
                <p class="text-muted small mt-2">Sign in to manage your active workspace</p>
            </div>


            <div class="card border-0 shadow-sm bg-white p-4 p-md-5 rounded-3">
                

                @if (session('status'))
                    <div class="alert alert-success small py-2 rounded-3 mb-4" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf


                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small text-secondary">Email Address</label>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               class="form-control rounded-3 @error('email') is-invalid @enderror" 
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
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label fw-semibold small text-secondary mb-0">Password</label>
                            @if (Route::has('password.request'))
                                <a class="small text-decoration-none text-primary fw-medium" href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        
                        <input id="password" 
                               type="password" 
                               name="password" 
                               class="form-control rounded-3 @error('password') is-invalid @enderror" 
                               placeholder="••••••••"
                               required 
                               autocomplete="current-password" />

                        @error('password')
                            <div class="invalid-feedback small fw-medium mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="form-check mb-4 mt-2">
                        <input id="remember_me" type="checkbox" name="remember" class="form-check-input rounded-1">
                        <label for="remember_me" class="form-check-label text-muted small user-select-none">
                            Keep me logged in on this device
                        </label>
                    </div>


                    <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold mb-2">
                         Sign In
                    </button>
                </form>


                <div class="text-center mt-3 pt-3 border-top border-light">
                    <span class="text-muted small">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-decoration-none text-primary fw-semibold small ms-1">
                        Register
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>