<?php

namespace App\Livewire;

use App\Models\Alumni;
use App\Models\AlumniEducation;
use App\Models\Announcement;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Batch Representative Dashboard')]
class BatchRepDashboard extends Component
{
    public function render()
    {
        $user = Auth::user()?->loadMissing([
            'alumni.educations.batch',
        ]);

        $representativeEducation = $user?->alumni?->educations()
            ->with('batch')
            ->where('is_batch_rep', true)
            ->first();

        abort_unless($representativeEducation?->batch_id, 403);

        $batchId = (int) $representativeEducation->batch_id;
        $currentBatch = $representativeEducation->batch;

        $now = now();
        $today = $now->toDateString();

        /*
        |--------------------------------------------------------------------------
        | Base batch member scope
        |--------------------------------------------------------------------------
        | We now scope through alumni_educations instead of alumni.batch_id.
        */
        $batchEducationQuery = AlumniEducation::query()
            ->where('batch_id', $batchId)
            ->with([
                'batch:id,level,yeargrad,schoolyear',
                'alumni.user:id,alumni_id,username,email',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Upcoming events
        |--------------------------------------------------------------------------
        */
        $upcomingEventsQuery = Event::query()
            ->where('is_active', true)
            ->whereDate('event_date', '>=', $today);

        /*
        |--------------------------------------------------------------------------
        | KPI counts
        |--------------------------------------------------------------------------
        */
        $batchAlumniCount = (clone $batchEducationQuery)->count();

        $registeredUsersCount = (clone $batchEducationQuery)
            ->whereHas('alumni.user')
            ->count();

        $upcomingEventsCount = (clone $upcomingEventsQuery)->count();

        $respondedMembersCount = Alumni::query()
            ->whereHas('educations', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            })
            ->whereHas('eventRsvps.event', function ($query) use ($today) {
                $query->where('is_active', true)
                    ->whereDate('event_date', '>=', $today);
            })
            ->count();

        $membersWithoutRsvpCount = Alumni::query()
            ->whereHas('educations', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            })
            ->whereDoesntHave('eventRsvps.event', function ($query) use ($today) {
                $query->where('is_active', true)
                    ->whereDate('event_date', '>=', $today);
            })
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Batch members list
        |--------------------------------------------------------------------------
        | We return AlumniEducation rows so we preserve the exact scoped batch.
        */
        $batchMembers = (clone $batchEducationQuery)
            ->orderByDesc('is_batch_rep')
            ->orderBy(
                Alumni::select('lname')
                    ->whereColumn('alumni.id', 'alumni_educations.alumni_id')
                    ->limit(1)
            )
            ->orderBy(
                Alumni::select('fname')
                    ->whereColumn('alumni.id', 'alumni_educations.alumni_id')
                    ->limit(1)
            )
            ->limit(10)
            ->get();

        $upcomingEvents = (clone $upcomingEventsQuery)
            ->orderBy('event_date')
            ->limit(5)
            ->get();

        $announcements = Announcement::query()
            ->where('is_published', true)
            ->where(function ($query) use ($now) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', $now);
            })
            ->orderByDesc('pinned')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('livewire.batch-rep-dashboard', [
            'currentBatch' => $currentBatch,
            'representativeEducation' => $representativeEducation,

            'batchAlumniCount' => $batchAlumniCount,
            'registeredUsersCount' => $registeredUsersCount,
            'upcomingEventsCount' => $upcomingEventsCount,
            'respondedMembersCount' => $respondedMembersCount,
            'membersWithoutRsvpCount' => $membersWithoutRsvpCount,

            'batchMembers' => $batchMembers,
            'upcomingEvents' => $upcomingEvents,
            'announcements' => $announcements,
        ]);
    }
}