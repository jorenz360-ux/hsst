<?php

use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a staff record', function () {
    $staff = Staff::create([
        'fname'           => 'Maria',
        'lname'           => 'Santos',
        'mname'           => null,
        'address_line_1'  => '123 Main St',
        'city'            => 'Tagbilaran',
        'state_province'  => 'Bohol',
        'postal_code'     => '6300',
        'country'         => 'Philippines',
        'years_working'   => 10,
        'position'        => 'Faculty',
    ]);

    expect($staff->fname)->toBe('Maria')
        ->and($staff->lname)->toBe('Santos')
        ->and($staff->years_working)->toBe(10);
});

it('user can belong to a staff record', function () {
    $staff = Staff::create([
        'fname'          => 'Jose',
        'lname'          => 'Reyes',
        'address_line_1' => '1 School Rd',
        'city'           => 'Tagbilaran',
        'state_province' => 'Bohol',
        'postal_code'    => '6300',
        'country'        => 'Philippines',
        'years_working'  => 5,
        'position'       => 'Principal',
    ]);

    $user = \App\Models\User::create([
        'username' => 'staff-reyesj',
        'email'    => 'jose@example.com',
        'password' => bcrypt('password'),
        'staff_id' => $staff->id,
        'is_active' => false,
    ]);

    expect($user->staff->lname)->toBe('Reyes');
    expect($staff->user->username)->toBe('staff-reyesj');
});
