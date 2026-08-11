@extends('layouts.dashboard')
@section('title', 'My Bids')

@section('content')
<h4 class="fw-bold mb-4">My Bids</h4>

@if($bids->isEmpty())
    <div class="bg-white rounded-3 shadow-sm p-5 text-center text-muted">
        <i class="bi bi-file-earmark-text fs-1 d-block mb-3 opacity-25"></i>
        <p>You haven't submitted any bids yet.</p>
        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-primary btn-sm">Browse Jobs</a>
    </div>
@else
    @foreach($bids as $bid)
    <div class="bg-white rounded-3 shadow-sm p-4 mb-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h6 class="fw-bold mb-1">{{ $bid->job->title }}</h6>
                <small class="text-muted">
                    <i class="bi bi-tag me-1"></i>{{ $bid->job->category->name ?? 'N/A' }} ·
                    <i class="bi bi-clock me-1"></i>{{ $bid->created_at->diffForHumans() }}
                </small>
                <div class="mt-2">
                    <span class="fw-semibold text-success">${{ number_format($bid->amount) }}</span>
                    <span class="text-muted small ms-2">· {{ $bid->delivery_days }} days delivery</span>
                </div>
            </div>
            <div class="text-end">
                <span class="badge
                    @if($bid->status == 'pending')  bg-warning text-dark
                    @elseif($bid->status == 'accepted') bg-success
                    @elseif($bid->status == 'rejected') bg-danger
                    @else bg-secondary @endif">
                    {{ ucfirst($bid->status) }}
                </span>
                @if($bid->isPending())
                <form action="{{ route('freelancer.bids.destroy', $bid) }}"
                      method="POST" class="mt-2">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Withdraw this bid?')">
                        Withdraw
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
    {{ $bids->links() }}
@endif
@endsection