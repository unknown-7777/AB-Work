<?php
namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBidRequest;
use App\Models\Bid;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BidController extends Controller
{

    public function create(Job $job): View
    {
        abort_if(!$job->isOpen(), 403, 'This job is no longer accepting bids.');
        abort_if($job->client_id === auth()->id(), 403, 'You cannot bid on your own job.');
        abort_if($job->hasUserBid(auth()->id()), 403, 'You already submitted a bid.');

        return view('freelancer.bids.create', compact('job'));
    }


    public function store(StoreBidRequest $request, Job $job): RedirectResponse
    {
        abort_if(!$job->isOpen(), 403);
        abort_if($job->hasUserBid(auth()->id()), 403, 'You already submitted a bid.');

        DB::transaction(function () use ($request, $job) {
            Bid::create([
                ...$request->validated(),
                'job_id'        => $job->id,
                'freelancer_id' => auth()->id(),
                'status'        => 'pending',
            ]);

            $job->increment('bids_count');
        });

        return redirect()
            ->route('freelancer.bids.index')
            ->with('success', 'Your bid was submitted successfully!');
    }


    public function index(): View
    {
        $bids = Bid::where('freelancer_id', auth()->id())
            ->with('job.category')
            ->latest()
            ->paginate(10);

        return view('freelancer.bids.index', compact('bids'));
    }


    public function destroy(Bid $bid): RedirectResponse
    {
        abort_if($bid->freelancer_id !== auth()->id(), 403);
        abort_if(!$bid->isPending(), 403, 'Only pending bids can be withdrawn.');

        DB::transaction(function () use ($bid) {
            $bid->update(['status' => 'withdrawn']);
            $bid->job->decrement('bids_count');
        });

        return redirect()
            ->route('freelancer.bids.index')
            ->with('success', 'Bid withdrawn.');
    }
}