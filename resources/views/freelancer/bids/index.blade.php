@extends('layouts.dashboard')
@section('title', __('app.my_bids'))

@section('content')
<h4 class="fw-bold mb-4">{{ __('app.my_bids') }}</h4>

@if($bids->isEmpty())
    <div class="bg-white rounded-3 shadow-sm p-5 text-center text-muted">
        <i class="bi bi-file-earmark-text fs-1 d-block mb-3 opacity-25"></i>
        <p>{{ __('app.no_bids_submitted') }}</p>
        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-primary btn-sm">
            {{ __('app.browse_jobs') }}
        </a>
    </div>
@else
    @foreach($bids as $bid)
        @if($bid->job)
        <div class="bg-white rounded-3 shadow-sm p-4 mb-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="fw-bold mb-1">{{ $bid->job->title }}</h6>
                    <small class="text-muted">
                        <i class="bi bi-tag me-1"></i>{{ $bid->job->category->name ?? __('app.no_data') }} ·
                        <i class="bi bi-clock me-1"></i>{{ $bid->created_at->diffForHumans() }}
                    </small>
                    <div class="mt-2">
                        <span class="fw-semibold text-success">${{ number_format($bid->amount) }}</span>
                        <span class="text-muted small ms-2">· {{ __('app.days_delivery', ['days' => $bid->delivery_days]) }}</span>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge
                        @if($bid->status === 'pending') bg-warning text-dark
                        @elseif($bid->status === 'accepted') bg-success
                        @elseif($bid->status === 'rejected') bg-danger
                        @else bg-secondary @endif">
                    
                        {{ \Illuminate\Support\Facades\Lang::has('app.status_' . $bid->status, app()->getLocale()) 
                            ? __('app.status_' . $bid->status) 
                            : ucfirst($bid->status) }}
                    
                    </span>

                    @if($bid->isPending())
                    <form action="{{ route('freelancer.bids.destroy', $bid) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('{{ __('app.confirm_withdraw_bid') }}')">
                            {{ __('app.withdraw') }}
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endif
    @endforeach

    {{ $bids->links() }}
@endif
@endsection