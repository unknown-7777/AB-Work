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

        $allMessages = Message::with(['sender', 'receiver', 'job'])
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->latest()
            ->get();

        $conversations = $allMessages->groupBy(function ($message) use ($userId) {
            return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
        })->map(function ($chatLogs) use ($userId) {
            $latestMessage = $chatLogs->first();
            
            $otherUser = $latestMessage->sender_id === $userId 
                ? $latestMessage->receiver : $latestMessage->sender;

            return (object) [
                'other_user'     => $otherUser,
                'latest_message' => $latestMessage,
                'job'            => $latestMessage->job 
            ];
        });

        return view('messages.index', compact('conversations'));
    }

    public function show(User $user): View
    {
        $userId = auth()->id();
    

        $activeJobs = Job::where(function ($q) use ($userId, $user) {
                $q->where('client_id', $userId)->where('hired_freelancer_id', $user->id);
            })
            ->orWhere(function ($q) use ($userId, $user) {
                $q->where('client_id', $user->id)->where('hired_freelancer_id', $userId);
            })
            ->whereIn('status', ['in_progress', 'completed'])
            ->latest()
            ->get();
    
        abort_if($activeJobs->isEmpty(), 404);
    
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
    
        $messages = Message::where(function($q) use ($userId, $user) {
                $q->where('sender_id', $userId)->where('receiver_id', $user->id);
            })
            ->orWhere(function($q) use ($userId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $userId);
            })
            ->with('sender')
            ->oldest()
            ->get();
    
        $otherUser = $user;
    

        return view('messages.show', compact('activeJobs', 'messages', 'otherUser'));
    }

    public function store(Request $request, User $user): RedirectResponse
    {
        $userId = auth()->id();

        $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $job = Job::where(function ($q) use ($userId, $user) {
                $q->where('client_id', $userId)->where('hired_freelancer_id', $user->id);
            })
            ->orWhere(function ($q) use ($userId, $user) {
                $q->where('client_id', $user->id)->where('hired_freelancer_id', $userId);
            })
            ->latest()
            ->firstOrFail();

        Message::create([
            'job_id'      => $job->id,
            'sender_id'   => $userId,
            'receiver_id' => $user->id,
            'body'        => $request->body,
        ]);

        return redirect()
            ->route('messages.show', $user->id)
            ->with('scrollToBottom', true);
    }

    public static function unreadCount(): int
    {
        return Message::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();
    }
}