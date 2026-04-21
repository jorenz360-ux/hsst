<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'reunion-coordinator', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'alumni', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'batch-representative', 'guard_name' => 'web']);
});

test('super-admin can access coordinator-only password reset requests route', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole('super-admin');

    $response = $this->actingAs($user)->get(route('admin.password-reset-requests'));

    $response->assertStatus(200);
});

test('super-admin can access coordinator-only attendance reports route', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole('super-admin');

    $response = $this->actingAs($user)->get(route('reports.attendance'));

    $response->assertStatus(200);
});

test('super-admin can access coordinator-only view-donations route', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole('super-admin');

    $response = $this->actingAs($user)->get(route('view-donations'));

    $response->assertStatus(200);
});

test('super-admin can access batch-representative-only donations route', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole('super-admin');

    $response = $this->actingAs($user)->get(route('donations'));

    $response->assertStatus(200);
});

test('super-admin can access the dashboard', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole('super-admin');

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertStatus(200);
});

test('alumni cannot access coordinator-only routes', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole('alumni');

    $response = $this->actingAs($user)->get(route('admin.password-reset-requests'));

    $response->assertStatus(403);
});

test('reunion-coordinator still has access to their routes', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole('reunion-coordinator');

    $response = $this->actingAs($user)->get(route('view-donations'));

    $response->assertStatus(200);
});
