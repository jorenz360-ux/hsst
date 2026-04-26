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
