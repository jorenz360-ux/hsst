<?php

use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a staff record', function () {
    $staff = Staff::create([
        'fname' => 'Maria',
        'lname' => 'Santos',
        'mname' => null,
        'address_line_1' => '123 Main St',
        'city' => 'Tagbilaran',
        'state_province' => 'Bohol',
        'postal_code' => '6300',
        'country' => 'Philippines',
        'years_working' => 10,
        'position' => 'Faculty',
    ]);

    expect($staff->fname)->toBe('Maria')
        ->and($staff->lname)->toBe('Santos')
        ->and($staff->years_working)->toBe(10);
});

it('user can belong to a staff record', function () {
    $staff = Staff::create([
        'fname' => 'Jose',
        'lname' => 'Reyes',
        'address_line_1' => '1 School Rd',
        'city' => 'Tagbilaran',
        'state_province' => 'Bohol',
        'postal_code' => '6300',
        'country' => 'Philippines',
        'years_working' => 5,
        'position' => 'Principal',
    ]);

    $user = \App\Models\User::create([
        'username' => 'staff-reyesj',
        'email' => 'jose@example.com',
        'password' => bcrypt('password'),
        'staff_id' => $staff->id,
        'is_active' => false,
    ]);

    expect($user->staff->lname)->toBe('Reyes');
    expect($staff->user->username)->toBe('staff-reyesj');
});

use App\Livewire\StaffRegister;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

it('renders the staff registration form', function () {
    $response = $this->get('/register/staff');
    $response->assertStatus(200);
});

it('registers a staff user with valid data', function () {
    Mail::fake();

    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'reunion-coordinator', 'guard_name' => 'web']);

    $coordinator = User::factory()->create(['email' => 'coord@example.com', 'is_active' => true]);
    $coordinator->assignRole('reunion-coordinator');

    Livewire::test(StaffRegister::class)
        ->set('fname', 'Maria')
        ->set('lname', 'Santos')
        ->set('address_line_1', '123 Main St')
        ->set('city', 'Tagbilaran')
        ->set('state_province', 'Bohol')
        ->set('postal_code', '6300')
        ->set('country', 'Philippines')
        ->set('years_working', 10)
        ->set('position', 'Faculty')
        ->set('account_type', 'staff')
        ->set('email', 'maria@example.com')
        ->set('password', 'SecurePass123!')
        ->set('password_confirmation', 'SecurePass123!')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect('/staff/pending');

    Mail::assertQueued(\App\Mail\StaffRegistrationPending::class);

    $user = User::where('email', 'maria@example.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->is_active)->toBeFalse()
        ->and($user->hasRole('staff'))->toBeTrue()
        ->and($user->staff->fname)->toBe('Maria');
});

it('fails validation when required fields are missing', function () {
    Livewire::test(StaffRegister::class)
        ->call('save')
        ->assertHasErrors(['fname', 'lname', 'email', 'password', 'account_type']);
});

it('fails validation when email is already taken', function () {
    User::factory()->create(['email' => 'taken@example.com']);

    Livewire::test(StaffRegister::class)
        ->set('fname', 'Jose')
        ->set('lname', 'Reyes')
        ->set('address_line_1', '1 St')
        ->set('city', 'Tagbilaran')
        ->set('state_province', 'Bohol')
        ->set('postal_code', '6300')
        ->set('country', 'Philippines')
        ->set('years_working', 3)
        ->set('position', 'Principal')
        ->set('account_type', 'employee')
        ->set('email', 'taken@example.com')
        ->set('password', 'SecurePass123!')
        ->set('password_confirmation', 'SecurePass123!')
        ->call('save')
        ->assertHasErrors(['email']);
});
