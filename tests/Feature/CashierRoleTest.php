<?php

use App\Actions\Fortify\LoginResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'cashier',              'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'reunion-coordinator',  'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'alumni',               'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'batch-representative', 'guard_name' => 'web']);
});

test('cashier login response redirects to donations route', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->syncRoles(['cashier']);

    $request = Request::create('/login', 'POST');
    $request->setUserResolver(fn () => $user);

    $response = app(LoginResponse::class)->toResponse($request);

    expect($response->getTargetUrl())->toContain(route('donations', absolute: false));
});

test('non-cashier login response redirects to dashboard', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->syncRoles(['alumni']);

    $request = Request::create('/login', 'POST');
    $request->setUserResolver(fn () => $user);

    $response = app(LoginResponse::class)->toResponse($request);

    expect($response->getTargetUrl())->toContain(route('dashboard', absolute: false));
});

test('cashier can access donations page', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->syncRoles(['cashier']);

    $this->actingAs($user)
        ->get(route('donations'))
        ->assertStatus(200);
});

test('cashier cannot access dashboard', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->syncRoles(['cashier']);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertStatus(403);
});

test('cashier can approve a donation', function () {
    $alumni = \App\Models\Alumni::create([
        'fname' => 'Test',
        'lname' => 'Donor',
        'mname' => null,
    ]);

    $donation = \App\Models\Donation::create([
        'alumni_id'    => $alumni->id,
        'amount'       => 500,
        'status'       => 'pending',
        'date_donated' => now(),
    ]);

    $cashier = \App\Models\User::factory()->create(['is_active' => true]);
    $cashier->syncRoles(['cashier']);

    \Livewire\Livewire::actingAs($cashier)
        ->test(\App\Livewire\ManageDonations::class)
        ->call('approveDonation', $donation->id)
        ->assertHasNoErrors();

    expect($donation->fresh()->status)->toBe('verified');
});
