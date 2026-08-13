@extends('layouts.dashboard')
@section('title', 'Chat')

@push('styles')
<style>
    .chat-container {
        height: 500px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 20px;
        background: #f8faff;
        border-radius: 12px;
    }
    .message-bubble {
        max-width: 70%;
        padding: 10px 16px;
        border-radius: 18px;
        font-size: 0.95rem;
        line-height: 1.5;
        word-break: break-word;
    }
    .message-mine {
        background: #2563eb;
        color: #fff;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }
    .message-theirs {
        background: #fff;
        color: #1e293b;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }
    .message-time {
        font-size: 0.72rem;
        opacity: 0.7;
        margin-top: 4px;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">


        <div class="bg-white rounded-3 shadow-sm p-3 mb-3 d-flex align-items-center gap-3">
            <a href="{{ route('messages.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            
            @if($otherUser && $otherUser->avatar)
                <img src="{{ $otherUser->avatarUrl() }}"
                     class="rounded-circle flex-shrink-0" width="48" height="48"
                     style="object-fit:cover;">
            @else
                <i class="bi bi-person-circle text-primary" style="font-size:48px; line-height:1;"></i>
            @endif
                
            <div>
                <div class="fw-bold">{{ $otherUser->name }}</div>
                <small class="text-muted">
                    <i class="bi bi-briefcase me-1"></i>{{ Str::limit($job->title, 40) }}
                </small>
            </div>
            <span class="ms-auto badge
                @if($job->status == 'in_progress') bg-primary
                @elseif($job->status == 'completed') bg-success
                @else bg-secondary @endif">
                {{ ucfirst(str_replace('_',' ',$job->status)) }}
            </span>
        </div>


        <div class="chat-container mb-3" id="chatContainer">
            @if($messages->isEmpty())
                <div class="text-center text-muted my-auto">
                    <i class="bi bi-chat fs-1 d-block mb-2 opacity-25"></i>
                    <p>No messages yet. Say hello! 👋</p>
                </div>
            @else
                @foreach($messages as $message)
                <div class="d-flex flex-column {{ $message->sender_id === auth()->id() ? 'align-items-end' : 'align-items-start' }}">
                    @if($message->sender_id !== auth()->id())
                        <small class="text-muted mb-1 ms-1">{{ $message->sender->name }}</small>
                    @endif
                    <div class="message-bubble {{ $message->sender_id === auth()->id() ? 'message-mine' : 'message-theirs' }}">
                        {{ $message->body }}
                    </div>
                    <div class="message-time {{ $message->sender_id === auth()->id() ? 'text-end' : '' }}">
                        {{ $message->created_at->format('M d, h:i A') }}
                        @if($message->sender_id === auth()->id())
                            @if($message->is_read)
                                <i class="bi bi-check-all text-info"></i>
                            @else
                                <i class="bi bi-check"></i>
                            @endif
                        @endif
                    </div>
                </div>
                @endforeach
            @endif
        </div>


        @if($job->status === 'in_progress' || $job->status === 'completed')
        <div class="bg-white rounded-3 shadow-sm p-3">
            <form action="{{ route('messages.store', $job) }}" method="POST">
                @csrf
                <div class="d-flex gap-2">
                    <textarea name="body" class="form-control" rows="2"
                              placeholder="Type your message..."
                              style="resize:none;" required>{{ old('body') }}</textarea>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </form>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>

    const chat = document.getElementById('chatContainer');
    if (chat) chat.scrollTop = chat.scrollHeight;


    setTimeout(() => location.reload(), 10000);
</script>
@endpush
@endsection