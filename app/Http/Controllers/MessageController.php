<?php
namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();


        $conversations = Job::where(function ($q) use ($userId) {
                $q->where('client_id', $userId)
                  ->orWhere('hired_freelancer_id', $userId);
            })
            ->whereIn('status', ['in_progress', 'completed'])
            ->with(['client', 'hiredFreelancer', 'messages' => function ($q) {
                $q->latest()->limit(1);
            }])
            ->latest()
            ->get();

        return view('messages.index', compact('conversations'));
    }


    public function show(Job $job): View
    {
        $userId = auth()->id();


        abort_if(
            $job->client_id !== $userId && $job->hired_freelancer_id !== $userId,
            403
        );


        Message::where('job_id', $job->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $messages = $job->messages()
            ->with('sender')
            ->oldest()
            ->get();


        $otherUser = $job->client_id === $userId
            ? $job->hiredFreelancer
            : $job->client;

        $job->load('client', 'hiredFreelancer');

        return view('messages.show', compact('job', 'messages', 'otherUser'));
    }


    public function store(Request $request, Job $job): RedirectResponse
    {
        $userId = auth()->id();

        abort_if(
            $job->client_id !== $userId && $job->hired_freelancer_id !== $userId,
            403
        );

        $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $receiverId = $job->client_id === $userId
            ? $job->hired_freelancer_id
            : $job->client_id;

        Message::create([
            'job_id'      => $job->id,
            'sender_id'   => $userId,
            'receiver_id' => $receiverId,
            'body'        => $request->body,
        ]);

        return redirect()
            ->route('messages.show', $job)
            ->with('scrollToBottom', true);
    }


    public static function unreadCount(): int
    {
        return Message::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();
    }
}