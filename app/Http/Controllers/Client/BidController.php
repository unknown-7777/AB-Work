<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{

    public function accept(Bid $bid): RedirectResponse
    {
        $job = $bid->job;


        abort_if($job->client_id !== auth()->id(), 403);
        abort_if(!$bid->isPending(), 403, 'This bid is no longer pending.');
        abort_if(!$job->isOpen(), 403, 'This job is no longer open.');

        DB::transaction(function () use ($bid, $job) {

            $bid->update(['status' => 'accepted']);


            $job->bids()
                ->where('id', '!=', $bid->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);


            $job->update([
                'status'              => 'in_progress',
                'hired_freelancer_id' => $bid->freelancer_id,
            ]);
        });

        return redirect()
            ->route('client.jobs.show', $job)
            ->with('success', 'Bid accepted! Project is now in progress.');
    }


    public function reject(Bid $bid): RedirectResponse
    {
        $job = $bid->job;

        abort_if($job->client_id !== auth()->id(), 403);
        abort_if(!$bid->isPending(), 403, 'This bid is no longer pending.');

        $bid->update(['status' => 'rejected']);

        return redirect()
            ->route('client.jobs.show', $job)
            ->with('success', 'Bid rejected.');
    }
}