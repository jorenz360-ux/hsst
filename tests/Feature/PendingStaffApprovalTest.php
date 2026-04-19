<?php

use App\Livewire\Admin\PendingStaff;
use App\Mail\StaffAccountApproved;
use App\Mail\StaffAccountRejected;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'reunion-coordinator', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
});

function makePendingStaffUser(): User
{
    $staff = Staff::create([
        'fname' => 'Maria', 'lname' => 'Santos',
        'address_line_1' => '1 St', 'city' => 'Tagbilaran',
        'state_province' => 'Bohol', 'postal_code' => '6300',
        'country' => 'Philippines', 'years_working' => 5,
        'position' => 'Faculty',
    ]);

    $user = User::create([
        'username' => 'staff-santosm',
        'email' => 'maria@example.com',
        'password' => bcrypt('password'),
        'staff_id' => $staff->id,
        'is_active' => false,
    ]);
    $user->assignRole('staff');

    return $user;
}

it('shows pending staff list to coordinator', function () {
    $coordinator = User::factory()->create();
    $coordinator->assignRole('reunion-coordinator');
    $pending = makePendingStaffUser();

    Livewire::actingAs($coordinator)
        ->test(PendingStaff::class)
        ->assertSee('Santos');
});

it('coordinator can approve a pending staff account', function () {
    Mail::fake();

    $coordinator = User::factory()->create();
    $coordinator->assignRole('reunion-coordinator');
    $pending = makePendingStaffUser();

    Livewire::actingAs($coordinator)
        ->test(PendingStaff::class)
        ->call('approve', $pending->id)
        ->assertHasNoErrors();

    expect($pending->fresh()->is_active)->toBeTrue();
    Mail::assertQueued(StaffAccountApproved::class);
});

it('coordinator can reject a pending staff account', function () {
    Mail::fake();

    $coordinator = User::factory()->create();
    $coordinator->assignRole('reunion-coordinator');
    $pending = makePendingStaffUser();
    $userId = $pending->id;
    $staffId = $pending->staff_id;

    Livewire::actingAs($coordinator)
        ->test(PendingStaff::class)
        ->call('reject', $userId)
        ->assertHasNoErrors();

    expect(User::find($userId))->toBeNull();
    expect(\App\Models\Staff::find($staffId))->toBeNull();
    Mail::assertQueued(StaffAccountRejected::class);
});

it('non-coordinator cannot access pending staff page', function () {
    $alumni = User::factory()->create(['is_active' => true]);
    Role::firstOrCreate(['name' => 'alumni', 'guard_name' => 'web']);
    $alumni->assignRole('alumni');

    $this->actingAs($alumni)
        ->get('/admin/pending-staff')
        ->assertForbidden();
});

it('non-coordinator cannot call approve via livewire', function () {
    Role::firstOrCreate(['name' => 'alumni', 'guard_name' => 'web']);
    $alumni = User::factory()->create(['is_active' => true]);
    $alumni->assignRole('alumni');
    $pending = makePendingStaffUser();

    Livewire::actingAs($alumni)
        ->test(PendingStaff::class)
        ->call('approve', $pending->id);

    expect($pending->fresh()->is_active)->toBeFalse();
});
