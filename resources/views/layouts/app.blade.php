<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">
    
    <style>
        body {
            background-color: #f3f4f6 !important;
        }
    </style>
</head>
<body class="bg-light">
    <div class="min-vh-100">
        @include('layouts.dashboard')

        @hasSection('header')
            <header class="bg-white shadow-sm border-bottom border-light py-3">
                <div class="container-fluid px-4">
                    @yield('header')
                </div>
            </header>
        @endif

        <main>
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>