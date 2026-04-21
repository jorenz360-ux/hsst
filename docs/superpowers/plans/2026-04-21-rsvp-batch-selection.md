# RSVP Batch Selection for Multi-Level Alumni Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Store which batch/level a multi-level alumni is attending as when they RSVP, and fix the attendance report to use that stored value instead of guessing.

**Architecture:** Add nullable `batch_id` FK to `event_rsvps`. In the RSVP Livewire component, auto-select the batch for single-level alumni and show a required dropdown for multi-level alumni. In the attendance report, join directly on `event_rsvps.batch_id` instead of the current `MAX(batch_id)` subquery.

**Tech Stack:** Laravel 12, Livewire 3, Pest 4, SQLite (tests), MySQL (production)

---

## File Map

| File | Action | Purpose |
|---|---|---|
| `database/migrations/2026_04_21_000001_add_batch_id_to_event_rsvps_table.php` | Create | Add nullable `batch_id` FK to `event_rsvps` |
| `app/Models/EventRsvp.php` | Modify | Add `batch_id` to `$fillable` and `$casts` |
| `app/Livewire/EventParticipationPage.php` | Modify | Add `$selectedBatchId`, `$alumniEducations`, auto-select logic, batch validation |
| `resources/views/livewire/event-participation-page.blade.php` | Modify | Conditional batch picker dropdown |
| `app/Livewire/AttendanceReport.php` | Modify | Replace MAX subquery with direct join on `event_rsvps.batch_id` |
| `tests/Feature/RsvpBatchSelectionTest.php` | Create | Tests for batch auto-select, required picker, save, and report query |

---

## Task 1: Migration — add `batch_id` to `event_rsvps`

**Files:**
- Create: `database/migrations/2026_04_21_000001_add_batch_id_to_event_rsvps_table.php`

- [ ] **Step 1: Create the migration file**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_rsvps', function (Blueprint $table) {
            $table->foreignId('batch_id')
                ->nullable()
                ->after('alumni_id')
                ->constrained('batches')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('event_rsvps', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropColumn('batch_id');
        });
    }
};
```

- [ ] **Step 2: Run the migration**

```bash
php artisan migrate
```

Expected: `Migrating: 2026_04_21_000001_add_batch_id_to_event_rsvps_table` then `Migrated`.

- [ ] **Step 3: Commit**

```bash
git add database/migrations/2026_04_21_000001_add_batch_id_to_event_rsvps_table.php
git commit -m "feat: add batch_id to event_rsvps table"
```

---

## Task 2: Update `EventRsvp` model

**Files:**
- Modify: `app/Models/EventRsvp.php`

- [ ] **Step 1: Add `batch_id` to `$fillable` and add the `batch()` relationship**

Open `app/Models/EventRsvp.php`. The current `$fillable` is:

```php
protected $fillable = [
    'event_id',
    'alumni_id',
    'status',
    'guest_count',
    'remarks',
];
```

Replace it with:

```php
protected $fillable = [
    'event_id',
    'alumni_id',
    'batch_id',
    'status',
    'guest_count',
    'remarks',
];
```

Then add the relationship method at the bottom of the class (before the closing `}`):

```php
public function batch()
{
    return $this->belongsTo(\App\Models\Batch::class);
}
```

- [ ] **Step 2: Commit**

```bash
git add app/Models/EventRsvp.php
git commit -m "feat: add batch_id to EventRsvp fillable and batch relationship"
```

---

## Task 3: Write failing tests

**Files:**
- Create: `tests/Feature/RsvpBatchSelectionTest.php`

- [ ] **Step 1: Create the test file**

```php
<?php

use App\Models\Alumni;
use App\Models\Batch;
use App\Models\Event;
use App\Models\EventRsvp;
use App\Models\User;
use App\Livewire\EventParticipationPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'alumni', 'guard_name' => 'web']);
});

function makeAlumniUser(): array
{
    $alumni = Alumni::create([
        'fname' => 'Juan',
        'lname' => 'Dela Cruz',
    ]);

    $user = User::factory()->create([
        'alumni_id' => $alumni->id,
        'is_active' => true,
    ]);
    $user->assignRole('alumni');

    return [$user, $alumni];
}

function makeEvent(): Event
{
    return Event::create([
        'title'     => 'Test Event',
        'is_active' => true,
    ]);
}

function makeBatch(string $level, int $yeargrad): Batch
{
    return Batch::create([
        'level'      => $level,
        'yeargrad'   => $yeargrad,
        'schoolyear' => ($yeargrad - 1) . '-' . $yeargrad,
    ]);
}

// ── Single-level alumni ──────────────────────────────────────────────────────

test('single-level alumni has batch auto-selected on mount', function () {
    [$user, $alumni] = makeAlumniUser();
    $batch = makeBatch('highschool', 2001);
    $event = makeEvent();

    $alumni->educations()->create([
        'batch_id'     => $batch->id,
        'did_graduate' => true,
    ]);

    Livewire::actingAs($user)
        ->test(EventParticipationPage::class, ['event' => $event])
        ->assertSet('selectedBatchId', $batch->id);
});

test('single-level alumni rsvp saves batch_id automatically', function () {
    [$user, $alumni] = makeAlumniUser();
    $batch = makeBatch('highschool', 2001);
    $event = makeEvent();

    $alumni->educations()->create([
        'batch_id'     => $batch->id,
        'did_graduate' => true,
    ]);

    Livewire::actingAs($user)
        ->test(EventParticipationPage::class, ['event' => $event])
        ->call('setRsvp', 'attending');

    $rsvp = EventRsvp::where('alumni_id', $alumni->id)
        ->where('event_id', $event->id)
        ->first();

    expect($rsvp)->not->toBeNull()
        ->and($rsvp->batch_id)->toBe($batch->id)
        ->and($rsvp->status)->toBe('attending');
});

// ── Multi-level alumni ───────────────────────────────────────────────────────

test('multi-level alumni has no batch auto-selected on mount', function () {
    [$user, $alumni] = makeAlumniUser();
    $batchHS  = makeBatch('highschool', 2001);
    $batchElem = makeBatch('elementary', 1995);
    $event = makeEvent();

    $alumni->educations()->create(['batch_id' => $batchHS->id,   'did_graduate' => true]);
    $alumni->educations()->create(['batch_id' => $batchElem->id, 'did_graduate' => true]);

    Livewire::actingAs($user)
        ->test(EventParticipationPage::class, ['event' => $event])
        ->assertSet('selectedBatchId', null);
});

test('multi-level alumni cannot rsvp without selecting a batch', function () {
    [$user, $alumni] = makeAlumniUser();
    $batchHS  = makeBatch('highschool', 2001);
    $batchElem = makeBatch('elementary', 1995);
    $event = makeEvent();

    $alumni->educations()->create(['batch_id' => $batchHS->id,   'did_graduate' => true]);
    $alumni->educations()->create(['batch_id' => $batchElem->id, 'did_graduate' => true]);

    Livewire::actingAs($user)
        ->test(EventParticipationPage::class, ['event' => $event])
        ->call('setRsvp', 'attending')
        ->assertSessionHas('error');

    expect(EventRsvp::where('alumni_id', $alumni->id)->exists())->toBeFalse();
});

test('multi-level alumni rsvp saves selected batch_id', function () {
    [$user, $alumni] = makeAlumniUser();
    $batchHS  = makeBatch('highschool', 2001);
    $batchElem = makeBatch('elementary', 1995);
    $event = makeEvent();

    $alumni->educations()->create(['batch_id' => $batchHS->id,   'did_graduate' => true]);
    $alumni->educations()->create(['batch_id' => $batchElem->id, 'did_graduate' => true]);

    Livewire::actingAs($user)
        ->test(EventParticipationPage::class, ['event' => $event])
        ->set('selectedBatchId', $batchHS->id)
        ->call('setRsvp', 'attending');

    $rsvp = EventRsvp::where('alumni_id', $alumni->id)
        ->where('event_id', $event->id)
        ->first();

    expect($rsvp)->not->toBeNull()
        ->and($rsvp->batch_id)->toBe($batchHS->id);
});

test('multi-level alumni can change batch when updating rsvp', function () {
    [$user, $alumni] = makeAlumniUser();
    $batchHS  = makeBatch('highschool', 2001);
    $batchElem = makeBatch('elementary', 1995);
    $event = makeEvent();

    $alumni->educations()->create(['batch_id' => $batchHS->id,   'did_graduate' => true]);
    $alumni->educations()->create(['batch_id' => $batchElem->id, 'did_graduate' => true]);

    // First RSVP as High School
    Livewire::actingAs($user)
        ->test(EventParticipationPage::class, ['event' => $event])
        ->set('selectedBatchId', $batchHS->id)
        ->call('setRsvp', 'attending');

    // Re-mount and change to Elementary
    Livewire::actingAs($user)
        ->test(EventParticipationPage::class, ['event' => $event])
        ->set('selectedBatchId', $batchElem->id)
        ->call('setRsvp', 'maybe');

    $rsvp = EventRsvp::where('alumni_id', $alumni->id)
        ->where('event_id', $event->id)
        ->first();

    expect($rsvp->batch_id)->toBe($batchElem->id)
        ->and($rsvp->status)->toBe('maybe');
});

test('existing rsvp batch_id is pre-selected on mount', function () {
    [$user, $alumni] = makeAlumniUser();
    $batchHS  = makeBatch('highschool', 2001);
    $batchElem = makeBatch('elementary', 1995);
    $event = makeEvent();

    $alumni->educations()->create(['batch_id' => $batchHS->id,   'did_graduate' => true]);
    $alumni->educations()->create(['batch_id' => $batchElem->id, 'did_graduate' => true]);

    // Pre-existing RSVP with High School batch
    EventRsvp::create([
        'event_id'  => $event->id,
        'alumni_id' => $alumni->id,
        'batch_id'  => $batchHS->id,
        'status'    => 'attending',
    ]);

    Livewire::actingAs($user)
        ->test(EventParticipationPage::class, ['event' => $event])
        ->assertSet('selectedBatchId', $batchHS->id);
});
```

- [ ] **Step 2: Run tests to verify they fail**

```bash
php artisan test tests/Feature/RsvpBatchSelectionTest.php
```

Expected: All tests FAIL — `selectedBatchId` property does not exist yet.

---

## Task 4: Update `EventParticipationPage` component

**Files:**
- Modify: `app/Livewire/EventParticipationPage.php`

- [ ] **Step 1: Replace the full component with the updated version**

```php
<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventRsvp;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Event Participation')]
class EventParticipationPage extends Component
{
    public Event $event;
    public ?EventRegistration $registration = null;
    public ?EventRsvp $rsvp = null;

    public ?string $rsvpStatus = null;
    public ?int $selectedBatchId = null;

    public int $attendingCount = 0;
    public int $maybeCount = 0;
    public int $notAttendingCount = 0;

    public Collection $alumniEducations;

    public function mount(Event $event): void
    {
        $alumniId = Auth::user()?->alumni_id;

        abort_if(! $alumniId, 403, 'Your alumni profile is required before you can continue.');
        abort_if(! $event->is_active, 403, 'This event is currently unavailable.');

        $this->alumniEducations = collect();

        $this->event = $event->load([
            'schedules' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('schedule_time'),
        ]);

        $this->registration = EventRegistration::firstOrCreate(
            [
                'event_id' => $this->event->id,
                'alumni_id' => $alumniId,
            ],
            [
                'status' => 'unpaid',
                'fee_paid' => 0,
            ]
        );

        $this->alumniEducations = Auth::user()
            ->alumni
            ->educations()
            ->with('batch')
            ->get();

        $this->loadRsvpState();
        $this->loadAttendanceCounts();
    }

    protected function loadRsvpState(): void
    {
        $alumniId = Auth::user()?->alumni_id;

        $this->rsvp = EventRsvp::query()
            ->where('event_id', $this->event->id)
            ->where('alumni_id', $alumniId)
            ->first();

        $this->rsvpStatus = $this->rsvp?->status;

        if ($this->rsvp?->batch_id) {
            // Pre-fill from existing RSVP
            $this->selectedBatchId = $this->rsvp->batch_id;
        } elseif ($this->alumniEducations->count() === 1) {
            // Auto-select when only one education record exists
            $this->selectedBatchId = $this->alumniEducations->first()->batch_id;
        }
    }

    protected function loadAttendanceCounts(): void
    {
        $this->attendingCount = EventRsvp::query()
            ->where('event_id', $this->event->id)
            ->where('status', EventRsvp::STATUS_ATTENDING)
            ->count();

        $this->maybeCount = EventRsvp::query()
            ->where('event_id', $this->event->id)
            ->where('status', EventRsvp::STATUS_MAYBE)
            ->count();

        $this->notAttendingCount = EventRsvp::query()
            ->where('event_id', $this->event->id)
            ->where('status', EventRsvp::STATUS_NOT_ATTENDING)
            ->count();
    }

    public function setRsvp(string $status): void
    {
        $allowedStatuses = [
            EventRsvp::STATUS_ATTENDING,
            EventRsvp::STATUS_MAYBE,
            EventRsvp::STATUS_NOT_ATTENDING,
        ];

        if (! in_array($status, $allowedStatuses, true)) {
            session()->flash('error', 'Invalid attendance response.');
            return;
        }

        if ($this->event->event_date?->isPast()) {
            session()->flash('error', 'This event is already closed.');
            return;
        }

        // Enforce batch selection for multi-level alumni
        if ($this->alumniEducations->count() > 1 && ! $this->selectedBatchId) {
            session()->flash('error', 'Please select which batch you are attending as.');
            return;
        }

        // Single-level: force the only batch
        if ($this->alumniEducations->count() === 1) {
            $this->selectedBatchId = $this->alumniEducations->first()->batch_id;
        }

        $alumniId = Auth::user()?->alumni_id;

        $this->rsvp = EventRsvp::updateOrCreate(
            [
                'event_id' => $this->event->id,
                'alumni_id' => $alumniId,
            ],
            [
                'status' => $status,
                'batch_id' => $this->selectedBatchId,
                'guest_count' => 0,
                'remarks' => null,
            ]
        );

        $this->rsvpStatus = $this->rsvp->status;

        $this->loadAttendanceCounts();

        $message = match ($status) {
            EventRsvp::STATUS_ATTENDING => 'Your RSVP has been marked as Attending.',
            EventRsvp::STATUS_MAYBE => 'Your RSVP has been marked as Maybe.',
            EventRsvp::STATUS_NOT_ATTENDING => 'Your RSVP has been marked as Not Attending.',
            default => 'Your RSVP has been updated.',
        };

        session()->flash('success', $message);
    }

    public function saveRsvp(): void
    {
        if (! in_array($this->rsvpStatus, [
            EventRsvp::STATUS_ATTENDING,
            EventRsvp::STATUS_MAYBE,
            EventRsvp::STATUS_NOT_ATTENDING,
        ], true)) {
            session()->flash('error', 'Please select your attendance response first.');
            return;
        }

        $this->setRsvp($this->rsvpStatus);
    }

    public function render()
    {
        return view('livewire.event-participation-page');
    }
}
```

- [ ] **Step 2: Run tests — most should now pass**

```bash
php artisan test tests/Feature/RsvpBatchSelectionTest.php
```

Expected: All tests PASS.

- [ ] **Step 3: Run full test suite to check for regressions**

```bash
php artisan test
```

Expected: All tests PASS.

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/EventParticipationPage.php
git commit -m "feat: add batch selection logic to EventParticipationPage"
```

---

## Task 5: Add batch picker to the RSVP blade view

**Files:**
- Modify: `resources/views/livewire/event-participation-page.blade.php`

- [ ] **Step 1: Add batch picker above the RSVP radio buttons**

Find this line in the blade (inside the `@else` block, just before the RSVP radio grid):

```blade
<p class="text-sm font-medium text-[#1a1410]">Will you attend this event?</p>
```

Insert the batch picker **above** that line:

```blade
@if ($alumniEducations->count() > 1)
    <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
        <label class="block text-[11px] font-semibold uppercase tracking-[0.2em] text-[#b88a3d] mb-2">
            Which batch are you attending as?
        </label>
        <select
            wire:model.live="selectedBatchId"
            class="w-full border border-[#d0c8bc] bg-white px-3 py-2 text-sm text-[#1a1410] focus:border-[#b88a3d] focus:outline-none"
        >
            <option value="">Select your batch…</option>
            @foreach ($alumniEducations as $edu)
                <option value="{{ $edu->batch_id }}">
                    {{ match($edu->batch->level ?? '') {
                        'elementary' => 'Elementary',
                        'highschool' => 'High School',
                        'college'    => 'College',
                        default      => 'Unknown Level',
                    } }} — {{ $edu->batch->schoolyear ?? $edu->batch->yeargrad ?? '—' }}
                </option>
            @endforeach
        </select>
    </div>
@endif
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/livewire/event-participation-page.blade.php
git commit -m "feat: show batch picker on RSVP page for multi-level alumni"
```

---

## Task 6: Fix attendance report query

**Files:**
- Modify: `app/Livewire/AttendanceReport.php`

- [ ] **Step 1: Remove the `MAX(batch_id)` subquery and replace with direct join**

In `reportQuery()`, find and remove this block:

```php
// Alumni no longer has batch_id directly; batches are linked via alumni_educations.
// Pick the education record with the highest batch_id per alumni as their primary batch.
$primaryBatch = DB::table('alumni_educations')
    ->select(['alumni_id', DB::raw('MAX(batch_id) as batch_id')])
    ->groupBy('alumni_id');
```

Then replace the `leftJoinSub` line:

```php
->leftJoinSub($primaryBatch, 'prim_edu', 'prim_edu.alumni_id', '=', 'alumni.id')
->leftJoin('batches', 'batches.id', '=', 'prim_edu.batch_id')
```

With a direct join on `event_rsvps.batch_id`:

```php
->leftJoin('batches', 'batches.id', '=', 'event_rsvps.batch_id')
```

The full updated `reportQuery()` method should look like this:

```php
protected function reportQuery(int $eventId)
{
    $query = Alumni::query()
        ->select(['alumni.id', 'alumni.fname', 'alumni.lname', 'alumni.mname'])
        ->leftJoin('event_rsvps', function ($join) use ($eventId) {
            $join->on('event_rsvps.alumni_id', '=', 'alumni.id')
                ->where('event_rsvps.event_id', '=', $eventId);
        })
        ->leftJoin('batches', 'batches.id', '=', 'event_rsvps.batch_id')
        ->leftJoin('event_registrations', function ($join) use ($eventId) {
            $join->on('event_registrations.alumni_id', '=', 'alumni.id')
                ->where('event_registrations.event_id', '=', $eventId);
        })
        ->addSelect([
            'batches.schoolyear',
            'batches.yeargrad',
            'batches.level as batch_level',
            'event_rsvps.id as rsvp_id',
            'event_rsvps.status as rsvp_status',
            'event_rsvps.guest_count',
            'event_rsvps.updated_at as rsvp_updated_at',
            'event_registrations.id as registration_id',
            'event_registrations.payment_status',
            'event_registrations.updated_at as payment_updated_at',
        ])
        ->selectRaw("
            CASE
                WHEN batches.schoolyear IS NOT NULL THEN batches.schoolyear
                WHEN batches.yeargrad IS NOT NULL THEN CAST(batches.yeargrad AS CHAR)
                ELSE 'No Batch'
            END as batch_label
        ")
        ->orderBy('batches.yeargrad')
        ->orderBy('alumni.lname')
        ->orderBy('alumni.fname');

    if ($this->levelFilter !== 'all') {
        $query->where('batches.level', $this->levelFilter);
    }

    if ($this->rsvpStatusFilter !== 'all') {
        if ($this->rsvpStatusFilter === 'no_response') {
            $query->whereNull('event_rsvps.id');
        } else {
            $query->where('event_rsvps.status', $this->rsvpStatusFilter);
        }
    }

    if ($this->paymentStatusFilter !== 'all') {
        $query->where('event_registrations.payment_status', $this->paymentStatusFilter);
    }

    if ($this->search !== '') {
        $search = trim($this->search);

        $query->where(function ($q) use ($search) {
            $q->where('alumni.fname', 'like', "%{$search}%")
                ->orWhere('alumni.lname', 'like', "%{$search}%")
                ->orWhere('alumni.mname', 'like', "%{$search}%")
                ->orWhere('batches.schoolyear', 'like', "%{$search}%")
                ->orWhere('batches.yeargrad', 'like', "%{$search}%");
        });
    }

    return $query;
}
```

Also remove the now-unused `DB` import at the top of the file if `DB` is no longer used elsewhere:

```php
use Illuminate\Support\Facades\DB;  // remove this line
```

- [ ] **Step 2: Run full test suite**

```bash
php artisan test
```

Expected: All tests PASS.

- [ ] **Step 3: Commit**

```bash
git add app/Livewire/AttendanceReport.php
git commit -m "fix: use event_rsvps.batch_id in attendance report instead of MAX subquery"
```

---

## Task 7: Manual smoke test

- [ ] **Step 1: Start the dev server**

```bash
composer dev
```

- [ ] **Step 2: Test single-level alumni**

Log in as an alumni who has exactly one education record. Navigate to any active event's participation page. Confirm no batch picker appears. Click Attending and save. Check the attendance report — batch and level columns should be populated correctly.

- [ ] **Step 3: Test multi-level alumni**

Log in as an alumni who has two or more education records (or create one via tinker — see below). Navigate to the event participation page. Confirm the "Which batch are you attending as?" dropdown appears. Try saving without selecting — confirm the error flash appears. Select a batch, save — confirm success. Go to attendance report, confirm the level filter shows only that alumni under the selected level.

**Tinker snippet to add a second education to an existing alumni:**

```bash
php artisan tinker
```

```php
$alumni = \App\Models\Alumni::find(<ID>);
$batch  = \App\Models\Batch::where('level', 'elementary')->first();
$alumni->educations()->create(['batch_id' => $batch->id, 'did_graduate' => true]);
```

- [ ] **Step 4: Verify level filter in attendance report**

Select an event, set the Level filter to "High School" — only alumni who RSVPd as High School should appear. Switch to "Elementary" — only those who RSVPd as Elementary appear.
