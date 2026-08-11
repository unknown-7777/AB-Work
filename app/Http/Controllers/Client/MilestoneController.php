<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MilestoneController extends Controller
{

    public function create(Job $job): View
    {
        abort_if($job->client_id !== auth()->id(), 403);
        abort_if(!$job->isInProgress(), 403, 'Job must be in progress.');

        $job->load('acceptedBid.freelancer');

        return view('client.milestones.create', compact('job'));
    }


    public function store(Request $request, Job $job): RedirectResponse
    {
        abort_if($job->client_id !== auth()->id(), 403);

        $request->validate([
            'milestones'                => ['required', 'array', 'min:1'],
            'milestones.*.title'        => ['required', 'string', 'max:150'],
            'milestones.*.amount'       => ['required', 'numeric', 'min:1'],
            'milestones.*.due_date'     => ['nullable', 'date', 'after:today'],
            'milestones.*.description'  => ['nullable', 'string'],
        ]);

        $acceptedBid = $job->acceptedBid;

        foreach ($request->milestones as $index => $data) {
            Milestone::create([
                'job_id'      => $job->id,
                'bid_id'      => $acceptedBid->id,
                'title'       => $data['title'],
                'amount'      => $data['amount'],
                'due_date'    => $data['due_date'] ?? null,
                'description' => $data['description'] ?? null,
                'order'       => $index + 1,
                'status'      => 'pending',
            ]);
        }

        return redirect()
            ->route('client.jobs.show', $job)
            ->with('success', 'Milestones created successfully!');
    }


    public function approve(Milestone $milestone): RedirectResponse
    {
        $job = $milestone->job;
        abort_if($job->client_id !== auth()->id(), 403);
        abort_if(!$milestone->isSubmitted(), 403, 'Milestone must be submitted first.');

        $milestone->update([
            'status'               => 'approved',
            'payment_released'     => true,
            'payment_released_at'  => now(),
        ]);


        $allApproved = $job->milestones()->where('status', '!=', 'approved')->doesntExist();
        if ($allApproved) {
            $job->update(['status' => 'completed']);
        }

        return redirect()
            ->route('client.jobs.show', $job)
            ->with('success', 'Milestone approved & payment released!');
    }


    public function revision(Request $request, Milestone $milestone): RedirectResponse
    {
        $job = $milestone->job;
        abort_if($job->client_id !== auth()->id(), 403);
        abort_if(!$milestone->isSubmitted(), 403);

        $request->validate([
            'revision_note' => ['required', 'string', 'min:10'],
        ]);

        $milestone->update([
            'status'        => 'revision',
            'revision_note' => $request->revision_note,
        ]);

        return redirect()
            ->route('client.jobs.show', $job)
            ->with('success', 'Revision requested.');
    }

    public function show(Job $job): View
    {
        abort_if($job->hired_freelancer_id !== auth()->id(), 403);
        $job->load('milestones', 'client');
        return view('freelancer.projects.show', compact('job'));
    }
}