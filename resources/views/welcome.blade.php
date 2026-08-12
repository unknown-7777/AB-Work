<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} – Find Work. Hire Talent.</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">
    <style>
        body { font-family: 'Segoe UI', sans-serif; }


        .navbar { background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .navbar-brand { font-weight: 800; font-size: 1.5rem; color: #2563eb !important; }


        .hero {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #0ea5e9 100%);
            min-height: 88vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero::after {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(255,255,255,0.08), transparent 70%);
            bottom: -100px; right: -100px;
            border-radius: 50%;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 50px;
            padding: 6px 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .hero h1 {
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
        }
        .hero h1 span {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero p { color: rgba(255,255,255,0.8); font-size: 1.15rem; }
        .btn-hero {
            background: #fff;
            color: #2563eb;
            font-weight: 700;
            border-radius: 10px;
            padding: 12px 30px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-hero:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.2); color: #2563eb; }
        .btn-hero-outline {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255,255,255,0.5);
            font-weight: 600;
            border-radius: 10px;
            padding: 12px 30px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-hero-outline:hover { border-color: #fff; color: #fff; background: rgba(255,255,255,0.1); }


        .stats-bar {
            background: #1e3a8a;
            padding: 28px 0;
        }
        .stat-number { font-size: 1.9rem; font-weight: 800; color: #fbbf24; }
        .stat-label  { color: rgba(255,255,255,0.7); font-size: 0.85rem; }


        .category-card {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 24px 16px;
            text-align: center;
            transition: all 0.25s;
            cursor: pointer;
            text-decoration: none;
            display: block;
            color: inherit;
        }
        .category-card:hover {
            border-color: #2563eb;
            box-shadow: 0 6px 20px rgba(37,99,235,0.12);
            transform: translateY(-4px);
            color: #2563eb;
        }
        .category-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }


        .how-section { background: #f8faff; padding: 90px 0; }
        .step-circle {
            width: 56px; height: 56px;
            background: #2563eb;
            border-radius: 50%;
            color: #fff;
            font-weight: 800;
            font-size: 1.2rem;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
        }


        .cta-section {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            padding: 90px 0;
            text-align: center;
        }


        footer { background: #0f172a; color: rgba(255,255,255,0.5); padding: 24px; text-align: center; font-size: 0.9rem; }
        footer span { color: #2563eb; font-weight: 700; }
    </style>
</head>
<body>

@guest
<nav class="navbar navbar-expand-lg sticky-top px-4 px-md-5">
    <a class="navbar-brand" href="#">
        <i class="bi bi-briefcase-fill me-1"></i>{{ config('app.name') }}
    </a>
    <div class="ms-auto d-flex gap-2">
        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-3">Login</a>
        <a href="{{ route('register') }}" class="btn btn-primary rounded-3 fw-600">Get Started</a>
    </div>
</nav>
@endguest

@auth
<nav class="navbar navbar-expand-lg sticky-top px-4 px-md-5">
    <a class="navbar-brand" href="#">
        <i class="bi bi-briefcase-fill me-1"></i>{{ config('app.name') }}
    </a>
    <div class="ms-auto d-flex gap-2">
        <a href="{{ route('logout') }}" class="btn btn-outline-danger rounded-3">Logout</a>
    </div>
</nav>
@endauth


<section class="hero">
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-badge">
                    <i class="bi bi-patch-check-fill me-1"></i> Trusted by 10,000+ professionals
                </div>
                <h1>
                    Find the perfect<br>
                    <span>Freelancer</span> for<br>
                    any job.
                </h1>
                <p class="my-4">
                    Connect with top freelancers for web development, design,
                    writing, marketing and more — or find your next client today.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('register') }}" class="btn-hero">
                        <i class="bi bi-rocket-takeoff me-2"></i>Hire a Freelancer
                    </a>
                    <a href="{{ route('register') }}" class="btn-hero-outline">
                        <i class="bi bi-person-badge me-2"></i>Find Work
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-center mt-5 mt-lg-0">
                <div class="p-4 bg-white rounded-4 shadow-lg" style="width:320px;">


                    <!-- Live Status Indicator with Pulsing Effect -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success rounded-circle me-2 position-relative" style="width:10px;height:10px;">
                            <span class="position-absolute top-0 start-0 w-100 h-100 bg-success rounded-circle opacity-75" style="animation: ab-ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite; content: ''; display: block;"></span>
                        </div>
                        <small class="text-muted fw-semibold">Live job posted</small>
                    </div>
            

                    <h6 class="fw-bold text-dark mb-1">Build a Laravel REST API</h6>
                    <p class="text-muted small mb-3">Budget: $500–$1,000 · Fixed Price</p>
                    

                    <div class="d-flex gap-2 mb-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">Laravel</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">PHP</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">MySQL</span>
                    </div>
                    

                    <div class="d-flex align-items-center justify-content-between pt-2 border-top border-light">
                        <small class="text-muted"><i class="bi bi-people-fill me-1 text-primary"></i> 12 bids</small>
                        <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2.5 py-1 rounded-pill">Open</span>
                    </div>
                </div>
            </div>
            

            <style>
                @keyframes ab-ping {
                    75%, 100% {
                        transform: scale(2.5);
                        opacity: 0;
                    }
                }
            </style>
        </div>
    </div>
</section>


<div class="stats-bar">
    <div class="container">
        <div class="row g-3 text-center">
            <div class="col-6 col-md-3">
                <div class="stat-number">10K+</div>
                <div class="stat-label">Freelancers</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">5K+</div>
                <div class="stat-label">Jobs Posted</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">98%</div>
                <div class="stat-label">Satisfaction Rate</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">$2M+</div>
                <div class="stat-label">Paid to Freelancers</div>
            </div>
        </div>
    </div>
</div>


<section class="py-5 mt-3">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-800 fs-2">Browse by Category</h2>
            <p class="text-muted">Find the right talent across every field</p>
        </div>
        <div class="row g-3">
            @foreach([
                ['icon'=>'bi-code-slash',    'label'=>'Web Development',   'jobs'=>'1,240'],
                ['icon'=>'bi-palette',        'label'=>'Design & Creative','jobs'=>'860'],
                ['icon'=>'bi-pen',            'label'=>'Writing',          'jobs'=>'540'],
                ['icon'=>'bi-megaphone',      'label'=>'Marketing',        'jobs'=>'430'],
                ['icon'=>'bi-phone',          'label'=>'Mobile Apps',      'jobs'=>'380'],
                ['icon'=>'bi-camera-video',   'label'=>'Video & Audio',    'jobs'=>'290'],
                ['icon'=>'bi-translate',      'label'=>'Translation',      'jobs'=>'210'],
                ['icon'=>'bi-graph-up-arrow', 'label'=>'Finance',          'jobs'=>'175'],
            ] as $cat)
            <div class="col-6 col-md-3">
                <a href="{{ route('register') }}" class="category-card">
                    <i class="bi {{ $cat['icon'] }} category-icon text-primary"></i>
                    <div class="fw-bold small">{{ $cat['label'] }}</div>
                    <div class="text-muted" style="font-size:0.78rem;">{{ $cat['jobs'] }} jobs</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>


<section class="how-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold fs-2">How It Works</h2>
            <p class="text-muted">Simple steps to get started</p>
        </div>
        <div class="row g-4 text-center">
            @foreach([
                ['n'=>1,'icon'=>'bi-person-plus',   'title'=>'Create Account',  'desc'=>'Sign up free as a client or freelancer in under a minute.'],
                ['n'=>2,'icon'=>'bi-file-post',     'title'=>'Post or Find Job','desc'=>'Clients post jobs. Freelancers browse and submit proposals.'],
                ['n'=>3,'icon'=>'bi-check2-circle', 'title'=>'Hire & Agree',    'desc'=>'Review bids, chat, and hire the best match for your project.'],
                ['n'=>4,'icon'=>'bi-stars',         'title'=>'Deliver & Review','desc'=>'Work gets done via milestones. Leave a review when complete.'],
            ] as $step)
            <div class="col-md-3">
                <div class="step-circle">{{ $step['n'] }}</div>
                <i class="bi {{ $step['icon'] }} fs-3 text-primary mb-2 d-block"></i>
                <h6 class="fw-bold">{{ $step['title'] }}</h6>
                <p class="text-muted small">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


<section class="cta-section">
    <div class="container">
        <h2 class="fw-800 text-white fs-1 mb-3">Ready to get started?</h2>
        <p class="text-white opacity-75 mb-4 fs-5">Join thousands of clients and freelancers already on {{ config('app.name') }}.</p>
        <a href="{{ route('register') }}" class="btn-hero">
            <i class="bi bi-rocket-takeoff me-2"></i>Join for Free
        </a>
    </div>
</section>

<footer>
    <p>© {{ date('Y') }} <span>{{ config('app.name') }}</span> — Find Work. Hire Talent.</p>
</footer>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>