@extends('layouts.dashboard')
@section('title', __('app.chat_with') . ' ' . $otherUser->name)

@section('content')
<div class="container-fluid p-0" style="margin-top: -1.5rem;">
    <div class="row g-0 bg-white rounded-3 shadow-sm overflow-hidden" style="height: calc(100vh - 120px); min-height: 500px;">
        
        <div class="col-12 d-flex flex-column h-100">
            
            <div class="p-3 border-bottom d-flex align-items-center justify-content-between bg-light">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;">
                        <i class="bi bi-arrow-left fs-5"></i>
                    </a>
                    
                    @if($otherUser->avatar)
                        <img src="{{ $otherUser->avatarUrl() }}" class="rounded-circle" width="45" height="45" style="object-fit:cover;">
                    @else
                        <i class="bi bi-person-circle text-primary" style="font-size:45px; line-height:1;"></i>
                    @endif
                    <div>
                        <h5 class="fw-bold mb-0">{{ $otherUser->name }}</h5>
                        @if($activeJobs->count() > 0)
                            <small class="text-primary fw-semibold">
                                {{ $activeJobs->count() > 1 ? __('app.active_projects') : __('app.active_project') }}: 
                                {{ $activeJobs->pluck('title')->implode(', ') }}
                            </small>
                        @endif
                    </div>
                </div>
                <div>
                    {{-- Safely grab status from the primary active job --}}
                    @if($latestJob = $activeJobs->first())
                        <span class="badge bg-secondary text-capitalize">
                            {{ __('app.' . $latestJob->status) }}
                        </span>
                    @endif
                </div>
            </div>

            <div id="chat-messages-box" class="flex-grow-1 p-4 overflow-y-auto bg-light bg-opacity-25" style="background-image: radial-gradient(#dfdfdf 1px, transparent 0); background-size: 24px 24px;">
                @forelse($messages as $message)
                    @php $isMe = $message->sender_id === auth()->id(); @endphp
                    <div class="d-flex mb-3 {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="max-w-70">
                            <div class="rounded-3 px-3 py-2 shadow-sm {{ $isMe ? 'bg-primary text-white rounded-end-0' : 'bg-white text-dark rounded-start-0' }}" style="max-width: 550px; word-wrap: break-word; white-space: pre-line;">
                                {{ $message->body }}
                            </div>
                            <small class="text-muted d-block mt-1 xx-small {{ $isMe ? 'text-end' : '' }}">
                                {{ $message->created_at->diffForHumans() }}
                                @if($isMe)
                                    · <i class="bi {{ $message->is_read ? 'bi-check2-all text-primary' : 'bi-check2' }}"></i>
                                @endif
                            </small>
                        </div>
                    </div>
                @empty
                    <div class="h-100 d-flex flex-column align-items-center justify-content-center text-muted">
                        <i class="bi bi-chat-left-text fs-1 opacity-25 mb-2"></i>
                        <p class="mb-0">{{ __('app.start_conversation') }}</p>
                    </div>
                @endforelse
            </div>

            <div class="p-3 border-top bg-white">
                <form id="chat-form" action="{{ route('messages.store', $otherUser->id) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <textarea 
                            id="chat-textarea"
                            name="body" 
                            class="form-control border-end-0 bg-light" 
                            placeholder="{{ __('app.type_a_message') }}"
                            rows="1"
                            style="resize: none; padding-top: 10px;"
                            required
                        ></textarea>
                        <button type="submit" class="btn btn-primary px-4 d-flex align-items-center">
                            <i class="bi bi-send-fill fs-5"></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const messageBox = document.getElementById('chat-messages-box');
        const textarea = document.getElementById('chat-textarea');
        const form = document.getElementById('chat-form');

        messageBox.scrollTop = messageBox.scrollHeight;

        textarea.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault(); 
                if (textarea.value.trim() !== '') {
                    form.submit(); 
                }
            }
        });
    });
</script>
@endsection