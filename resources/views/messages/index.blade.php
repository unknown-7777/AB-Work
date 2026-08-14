@extends('layouts.dashboard')
@section('title', __('app.messages'))

@section('content')
<h4 class="fw-bold mb-4">{{ __('app.messages') }}</h4>

@if($conversations->isEmpty())
    <div class="bg-white rounded-3 shadow-sm p-5 text-center text-muted">
        <i class="bi bi-chat-dots fs-1 d-block mb-3 opacity-25"></i>
        <p>{{ __('app.no_conversations') }}</p>
        <p class="small">{{ __('app.messages_appear') }}</p>
    </div>
@else
    <div class="bg-white rounded-3 shadow-sm">
        @foreach($conversations as $conversation)
        @php
            $otherUser = $conversation->other_user;
            $lastMsg   = $conversation->latest_message;
            $job       = $conversation->job;
            
            $unread    = \App\Models\Message::where('sender_id', $otherUser->id)
                                    ->where('receiver_id', auth()->id())
                                    ->where('is_read', false)
                                    ->count();
        @endphp
        <a href="{{ route('messages.show', $otherUser->id) }}"
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
                    <span class="fw-bold">{{ $otherUser->name ?? __('app.no_data') }}</span>
                    @if($lastMsg)
                        <small class="text-muted">{{ $lastMsg->created_at->diffForHumans() }}</small>
                    @endif
                </div>
                <div class="text-muted small text-truncate">
                    @if($job)
                        <span class="text-primary fw-semibold">{{ Str::limit($job->title, 25) }}</span>
                    @endif
                    @if($lastMsg)
                        · {{ Str::limit($lastMsg->body, 40) }}
                    @else
                        · {{ __('app.no_messages_yet') }}
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