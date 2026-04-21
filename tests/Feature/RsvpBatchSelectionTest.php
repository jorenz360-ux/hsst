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
