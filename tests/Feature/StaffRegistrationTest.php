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
