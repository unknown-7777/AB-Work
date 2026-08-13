<?php
namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function create(Job $job): View
    {
        $user = auth()->user();

        abort_if(
            $job->client_id !== $user->id && $job->hired_freelancer_id !== $user->id,
            403
        );
        abort_if(!$job->isCompleted(), 403, 'Job must be completed before leaving a review.');

        $alreadyReviewed = Review::where('job_id', $job->id)
            ->where('reviewer_id', $user->id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()
                ->back()
                ->with('error', 'You already submitted a review for this job.');
        }

        // Who are we reviewing?
        $reviewee = $user->isClient()
            ? $job->hiredFreelancer
            : $job->client;

        return view('reviews.create', compact('job', 'reviewee'));
    }

    public function store(Request $request, Job $job): RedirectResponse
    {
        $user = auth()->user();

        abort_if(
            $job->client_id !== $user->id && $job->hired_freelancer_id !== $user->id,
            403
        );
        abort_if(!$job->isCompleted(), 403);

        $alreadyReviewed = Review::where('job_id', $job->id)
            ->where('reviewer_id', $user->id)
            ->exists();

        abort_if($alreadyReviewed, 403, 'You already reviewed this job.');

        $request->validate([
            'rating'         => ['required', 'integer', 'min:1', 'max:5'],
            'communication'  => ['nullable', 'integer', 'min:1', 'max:5'],
            'quality'        => ['nullable', 'integer', 'min:1', 'max:5'],
            'professionalism'=> ['nullable', 'integer', 'min:1', 'max:5'],
            'comment'        => ['nullable', 'string', 'max:1000'],
        ]);

        $reviewee_id = $user->isClient()
            ? $job->hired_freelancer_id
            : $job->client_id;

        Review::create([
            'job_id'          => $job->id,
            'reviewer_id'     => $user->id,
            'reviewee_id'     => $reviewee_id,
            'rating'          => $request->rating,
            'communication'   => $request->communication,
            'quality'         => $request->quality,
            'professionalism' => $request->professionalism,
            'comment'         => $request->comment,
            'is_public'       => true,
        ]);

        // Redirect back to correct dashboard
        if ($user->isClient()) {
            return redirect()
                ->route('client.jobs.show', $job)
                ->with('success', 'Review submitted! Thank you for your feedback.');
        }

        return redirect()
            ->route('freelancer.projects.show', $job)
            ->with('success', 'Review submitted! Thank you for your feedback.');
    }
}