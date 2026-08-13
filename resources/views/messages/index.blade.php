@extends('layouts.dashboard')
@section('title', 'Messages')

@section('content')
<h4 class="fw-bold mb-4">Messages</h4>

@if($conversations->isEmpty())
    <div class="bg-white rounded-3 shadow-sm p-5 text-center text-muted">
        <i class="bi bi-chat-dots fs-1 d-block mb-3 opacity-25"></i>
        <p>No conversations yet.</p>
        <p class="small">Messages appear here once a bid is accepted.</p>
    </div>
@else
    <div class="bg-white rounded-3 shadow-sm">
        @foreach($conversations as $job)
        @php
            $userId    = auth()->id();
            $otherUser = $job->client_id === $userId ? $job->hiredFreelancer : $job->client;
            $lastMsg   = $job->messages->first();
            $unread    = \App\Models\Message::where('job_id', $job->id)
                            ->where('receiver_id', $userId)
                            ->where('is_read', false)
                            ->count();
        @endphp
        <a href="{{ route('messages.show', $job) }}"
           class="d-flex align-items-center gap-3 p-3 border-bottom text-decoration-none text-dark
                  {{ $unread > 0 ? 'bg-primary bg-opacity-10' : '' }}"
           style="transition: background 0.2s;">

           @if($otherUser && $otherUser->avatar)
               <img src="{{ $otherUser->avatarUrl() }}"
                    class="rounded-circle flex-shrink-0" width="48" height="48"
                    style="object-fit:cover;">
           @else
               <i class="bi bi-person-circle text-primary" style="font-size:48px; line-height:1;"></i>
           @endif

           <div class="flex-grow-1 overflow-hidden">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">{{ $otherUser->name ?? 'Unknown' }}</span>
                    @if($lastMsg)
                        <small class="text-muted">{{ $lastMsg->created_at->diffForHumans() }}</small>
                    @endif
                </div>
                <div class="text-muted small text-truncate">
                    <span class="text-primary fw-semibold">{{ Str::limit($job->title, 25) }}</span>
                    @if($lastMsg)
                        · {{ Str::limit($lastMsg->body, 40) }}
                    @else
                        · No messages yet
                    @endif
                </div>
            </div>
            @if($unread > 0)
                <span class="badge bg-primary rounded-pill">{{ $unread }}</span>
            @endif
        </a>
        @endforeach
    </div>
@endif
@endsection