<?php
namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MilestoneController extends Controller
{

    public function submit(Request $request, Milestone $milestone): RedirectResponse
    {
        $job = $milestone->job;
        abort_if($job->hired_freelancer_id !== auth()->id(), 403);
        abort_if(!in_array($milestone->status, ['pending', 'in_progress', 'revision']), 403);

        $request->validate([
            'submission_note' => ['required', 'string', 'min:10'],
        ]);

        $milestone->update([
            'status'          => 'submitted',
            'submission_note' => $request->submission_note,
        ]);

        return redirect()
            ->route('freelancer.projects.show', $job)
            ->with('success', 'Milestone submitted for review!');
    }
}