# Non-Alumni Self-Registration Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Allow non-alumni school personnel (staff, employee, ssps-member) to self-register, await coordinator approval, and RSVP to events via a simplified dashboard.

**Architecture:** New `Staff` model alongside existing `Alumni`. `User` gains a nullable `staff_id` FK. Three new Spatie roles with a single `view.staff.dashboard` permission. Admin approval flips `is_active` on the `User`; rejection deletes both records. Registration does NOT auto-login — user sees a pending page instead.

**Tech Stack:** Laravel 12, Livewire 3, Spatie Permission, Pest 4, SQLite (tests), Mailtrap (dev email)

---

## File Map

| Action | Path | Purpose |
|---|---|---|
| Create | `database/migrations/..._create_staff_table.php` | staff table |
| Create | `database/migrations/..._add_staff_id_to_users_table.php` | FK on users |
| Create | `database/migrations/..._add_non_alumni_roles.php` | roles + permission via migration |
| Create | `app/Models/Staff.php` | Staff Eloquent model |
| Modify | `app/Models/User.php` | add staff_id fillable + staff() relation |
| Create | `app/Livewire/StaffRegister.php` | self-registration component |
| Create | `resources/views/livewire/staff-register.blade.php` | registration form |
| Create | `app/Livewire/Admin/PendingStaff.php` | approve/reject component |
| Create | `resources/views/livewire/admin/pending-staff.blade.php` | pending list view |
| Create | `resources/views/livewire/staff-dashboard.blade.php` | non-alumni dashboard |
| Modify | `resources/views/dashboard.blade.php` | add staff dashboard include |
| Create | `app/Mail/StaffRegistrationPending.php` | notify coordinator of new registration |
| Create | `resources/views/mail/staff-registration-pending.blade.php` | email template |
| Create | `app/Mail/StaffAccountApproved.php` | notify staff of approval |
| Create | `resources/views/mail/staff-account-approved.blade.php` | email template |
| Create | `app/Mail/StaffAccountRejected.php` | notify staff of rejection |
| Create | `resources/views/mail/staff-account-rejected.blade.php` | email template |
| Modify | `routes/web.php` | add register/staff, staff/pending, admin/pending-staff routes |
| Create | `tests/Feature/StaffRegistrationTest.php` | registration tests |
| Create | `tests/Feature/PendingStaffApprovalTest.php` | approval/rejection tests |

---

## Task 1: Staff Table Migration + Model

**Files:**
- Create: `database/migrations/2026_04_19_000001_create_staff_table.php`
- Create: `app/Models/Staff.php`
- Create: `tests/Feature/StaffRegistrationTest.php` (partial — model assertions)

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/StaffRegistrationTest.php`:

```php
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
```

- [ ] **Step 2: Run test to verify it fails**

```bash
php artisan test tests/Feature/StaffRegistrationTest.php --filter="can create a staff record"
```

Expected: FAIL — `Staff` class not found.

- [ ] **Step 3: Create the migration**

Create `database/migrations/2026_04_19_000001_create_staff_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('fname', 80);
            $table->string('lname', 80);
            $table->string('mname', 80)->nullable();
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('city');
            $table->string('state_province');
            $table->string('postal_code');
            $table->string('country')->default('Philippines');
            $table->unsignedInteger('years_working');
            $table->string('position');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
```

- [ ] **Step 4: Create the Staff model**

Create `app/Models/Staff.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname',
        'lname',
        'mname',
        'address_line_1',
        'address_line_2',
        'city',
        'state_province',
        'postal_code',
        'country',
        'years_working',
        'position',
    ];

    protected function fname(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? ucwords(strtolower($value), " \t\r\n\f\v-.'") : $value,
        );
    }

    protected function lname(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? ucwords(strtolower($value), " \t\r\n\f\v-.'") : $value,
        );
    }

    protected function mname(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? ucwords(strtolower($value), " \t\r\n\f\v-.'") : $value,
        );
    }

    public function user()
    {
        return $this->hasOne(User::class, 'staff_id');
    }
}
```

- [ ] **Step 5: Run migration and test**

```bash
php artisan migrate
php artisan test tests/Feature/StaffRegistrationTest.php --filter="can create a staff record"
```

Expected: PASS

- [ ] **Step 6: Commit**

```bash
git add database/migrations/2026_04_19_000001_create_staff_table.php app/Models/Staff.php tests/Feature/StaffRegistrationTest.php
git commit -m "feat: add Staff model and migration"
```

---

## Task 2: Add staff_id to Users Table + Update User Model

**Files:**
- Create: `database/migrations/2026_04_19_000002_add_staff_id_to_users_table.php`
- Modify: `app/Models/User.php`

- [ ] **Step 1: Write the failing test**

Append to `tests/Feature/StaffRegistrationTest.php`:

```php
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
```

- [ ] **Step 2: Run test to verify it fails**

```bash
php artisan test tests/Feature/StaffRegistrationTest.php --filter="user can belong to a staff record"
```

Expected: FAIL — column `staff_id` does not exist.

- [ ] **Step 3: Create the migration**

Create `database/migrations/2026_04_19_000002_add_staff_id_to_users_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('staff_id')
                ->nullable()
                ->after('alumni_id')
                ->constrained('staff')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Staff::class);
            $table->dropColumn('staff_id');
        });
    }
};
```

- [ ] **Step 4: Update User model**

In `app/Models/User.php`, add `staff_id` to `$fillable` and add the relationship:

```php
protected $fillable = [
    'username',
    'email',
    'password',
    'alumni_id',
    'staff_id',
    'must_change_password',
    'is_active',
];
```

Add after the `alumni()` method:

```php
public function staff()
{
    return $this->belongsTo(Staff::class, 'staff_id');
}
```

- [ ] **Step 5: Run migration and test**

```bash
php artisan migrate
php artisan test tests/Feature/StaffRegistrationTest.php --filter="user can belong to a staff record"
```

Expected: PASS

- [ ] **Step 6: Commit**

```bash
git add database/migrations/2026_04_19_000002_add_staff_id_to_users_table.php app/Models/User.php tests/Feature/StaffRegistrationTest.php
git commit -m "feat: add staff_id to users table and User model relationship"
```

---

## Task 3: Add New Roles and Permission via Migration

**Files:**
- Create: `database/migrations/2026_04_19_000003_add_non_alumni_roles.php`

- [ ] **Step 1: Create the migration**

Create `database/migrations/2026_04_19_000003_add_non_alumni_roles.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $guard = 'web';

        $permission = Permission::firstOrCreate([
            'name'       => 'view.staff.dashboard',
            'guard_name' => $guard,
        ]);

        foreach (['staff', 'employee', 'ssps-member'] as $roleName) {
            $role = Role::firstOrCreate([
                'name'       => $roleName,
                'guard_name' => $guard,
            ]);
            $role->givePermissionTo($permission);
        }
    }

    public function down(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (['staff', 'employee', 'ssps-member'] as $roleName) {
            Role::where('name', $roleName)->where('guard_name', 'web')->first()?->delete();
        }

        Permission::where('name', 'view.staff.dashboard')->where('guard_name', 'web')->first()?->delete();
    }
};
```

- [ ] **Step 2: Run migration**

```bash
php artisan migrate
```

Expected: no errors, roles staff/employee/ssps-member now exist in DB.

- [ ] **Step 3: Verify roles exist**

```bash
php artisan permission:show
```

Expected: `staff`, `employee`, `ssps-member` rows visible with `view.staff.dashboard` checked.

- [ ] **Step 4: Commit**

```bash
git add database/migrations/2026_04_19_000003_add_non_alumni_roles.php
git commit -m "feat: add staff/employee/ssps-member roles and view.staff.dashboard permission"
```

---

## Task 4: Email Mailable Classes

**Files:**
- Create: `app/Mail/StaffRegistrationPending.php`
- Create: `resources/views/mail/staff-registration-pending.blade.php`
- Create: `app/Mail/StaffAccountApproved.php`
- Create: `resources/views/mail/staff-account-approved.blade.php`
- Create: `app/Mail/StaffAccountRejected.php`
- Create: `resources/views/mail/staff-account-rejected.blade.php`

- [ ] **Step 1: Create StaffRegistrationPending mailable**

Create `app/Mail/StaffRegistrationPending.php`:

```php
<?php

namespace App\Mail;

use App\Models\Staff;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffRegistrationPending extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Staff $staff,
        public readonly string $accountType,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Non-Alumni Registration Pending Approval',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.staff-registration-pending',
        );
    }
}
```

- [ ] **Step 2: Create StaffRegistrationPending email template**

Create `resources/views/mail/staff-registration-pending.blade.php`:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Approval</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f4f4f5; margin: 0; padding: 32px 16px; color: #18181b; }
        .wrapper { max-width: 520px; margin: 0 auto; }
        .card { background: #ffffff; border-radius: 16px; padding: 40px 36px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        .logo { font-size: 13px; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: #d97706; margin-bottom: 28px; }
        h1 { font-size: 22px; font-weight: 700; margin: 0 0 8px; }
        p { font-size: 15px; color: #52525b; line-height: 1.6; margin: 0 0 16px; }
        .info { background: #f8f8f8; border: 1px solid #e4e4e7; border-radius: 12px; padding: 20px 24px; margin: 24px 0; }
        .info dt { font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: #71717a; margin-bottom: 3px; }
        .info dd { font-size: 15px; font-weight: 600; color: #18181b; margin: 0 0 12px; }
        .footer { text-align: center; font-size: 12px; color: #a1a1aa; margin-top: 28px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="logo">Holy Spirit School Alumni Reunion</div>
            <h1>New Registration Pending</h1>
            <p>A non-alumni user has registered and is awaiting your approval.</p>
            <div class="info">
                <dl>
                    <dt>Name</dt>
                    <dd>{{ $staff->fname }} {{ $staff->lname }}</dd>
                    <dt>Position</dt>
                    <dd>{{ $staff->position }}</dd>
                    <dt>Account Type</dt>
                    <dd>{{ ucfirst($accountType) }}</dd>
                    <dt>Years at HSST</dt>
                    <dd>{{ $staff->years_working }}</dd>
                </dl>
            </div>
            <p>Please log in to the admin panel and visit <strong>Pending Staff</strong> to approve or reject this registration.</p>
        </div>
        <div class="footer">This email was sent by the HSST Alumni Reunion system. Do not reply.</div>
    </div>
</body>
</html>
```

- [ ] **Step 3: Create StaffAccountApproved mailable**

Create `app/Mail/StaffAccountApproved.php`:

```php
<?php

namespace App\Mail;

use App\Models\Staff;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffAccountApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Staff $staff,
        public readonly string $username,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your HSST Reunion Account Has Been Approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.staff-account-approved',
        );
    }
}
```

- [ ] **Step 4: Create StaffAccountApproved email template**

Create `resources/views/mail/staff-account-approved.blade.php`:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Approved</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f4f4f5; margin: 0; padding: 32px 16px; color: #18181b; }
        .wrapper { max-width: 520px; margin: 0 auto; }
        .card { background: #ffffff; border-radius: 16px; padding: 40px 36px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        .logo { font-size: 13px; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: #d97706; margin-bottom: 28px; }
        h1 { font-size: 22px; font-weight: 700; margin: 0 0 8px; }
        p { font-size: 15px; color: #52525b; line-height: 1.6; margin: 0 0 16px; }
        .credentials { background: #f8f8f8; border: 1px solid #e4e4e7; border-radius: 12px; padding: 20px 24px; margin: 24px 0; }
        .credentials dt { font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: #71717a; margin-bottom: 3px; }
        .credentials dd { font-size: 16px; font-weight: 600; font-family: 'Courier New', monospace; color: #18181b; margin: 0 0 16px; }
        .footer { text-align: center; font-size: 12px; color: #a1a1aa; margin-top: 28px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="logo">Holy Spirit School Alumni Reunion</div>
            <h1>Your account is approved, {{ $staff->fname }}!</h1>
            <p>Your registration for the HSST Reunion 2026 has been approved. You can now log in using your username and the password you set during registration.</p>
            <div class="credentials">
                <dl>
                    <dt>Username</dt>
                    <dd>{{ $username }}</dd>
                </dl>
            </div>
            <p>Visit the site and log in to signify your attendance.</p>
        </div>
        <div class="footer">This email was sent by the HSST Alumni Reunion system. Do not reply.</div>
    </div>
</body>
</html>
```

- [ ] **Step 5: Create StaffAccountRejected mailable**

Create `app/Mail/StaffAccountRejected.php`:

```php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffAccountRejected extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $fullName,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'HSST Reunion Registration Update',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.staff-account-rejected',
        );
    }
}
```

- [ ] **Step 6: Create StaffAccountRejected email template**

Create `resources/views/mail/staff-account-rejected.blade.php`:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Update</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f4f4f5; margin: 0; padding: 32px 16px; color: #18181b; }
        .wrapper { max-width: 520px; margin: 0 auto; }
        .card { background: #ffffff; border-radius: 16px; padding: 40px 36px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        .logo { font-size: 13px; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: #d97706; margin-bottom: 28px; }
        h1 { font-size: 22px; font-weight: 700; margin: 0 0 8px; }
        p { font-size: 15px; color: #52525b; line-height: 1.6; margin: 0 0 16px; }
        .footer { text-align: center; font-size: 12px; color: #a1a1aa; margin-top: 28px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="logo">Holy Spirit School Alumni Reunion</div>
            <h1>Hello, {{ $fullName }}</h1>
            <p>Thank you for registering for the HSST Reunion 2026. Unfortunately, your registration could not be approved at this time.</p>
            <p>If you believe this is an error, please contact the reunion coordinator directly.</p>
        </div>
        <div class="footer">This email was sent by the HSST Alumni Reunion system. Do not reply.</div>
    </div>
</body>
</html>
```

- [ ] **Step 7: Commit**

```bash
git add app/Mail/ resources/views/mail/staff-registration-pending.blade.php resources/views/mail/staff-account-approved.blade.php resources/views/mail/staff-account-rejected.blade.php
git commit -m "feat: add staff registration email mailables"
```

---

## Task 5: StaffRegister Livewire Component

**Files:**
- Create: `app/Livewire/StaffRegister.php`
- Create: `resources/views/livewire/staff-register.blade.php`
- Modify: `routes/web.php`

- [ ] **Step 1: Write failing tests**

Append to `tests/Feature/StaffRegistrationTest.php`:

```php
use App\Livewire\StaffRegister;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

it('renders the staff registration form', function () {
    $response = $this->get('/register/staff');
    $response->assertStatus(200);
});

it('registers a staff user with valid data', function () {
    Mail::fake();

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
```

- [ ] **Step 2: Run tests to verify they fail**

```bash
php artisan test tests/Feature/StaffRegistrationTest.php
```

Expected: multiple FAIL — class `StaffRegister` not found, route not found.

- [ ] **Step 3: Add routes**

In `routes/web.php`, add before `require __DIR__.'/settings.php';`:

```php
Route::get('/register/staff', \App\Livewire\StaffRegister::class)->name('register.staff');
Route::view('/staff/pending', 'staff-pending')->name('staff.pending');
```

- [ ] **Step 4: Create the pending view**

Create `resources/views/staff-pending.blade.php`:

```blade
<x-layouts.app :title="__('Registration Pending')">
    <div class="flex min-h-[60vh] items-center justify-center">
        <div class="max-w-md text-center">
            <div class="mb-4 text-5xl">⏳</div>
            <h1 class="mb-2 text-2xl font-bold text-gray-900">Registration Submitted</h1>
            <p class="text-gray-600">Your registration is pending approval by the reunion coordinator. You will receive an email once your account has been reviewed.</p>
        </div>
    </div>
</x-layouts.app>
```

- [ ] **Step 5: Create the StaffRegister Livewire component**

Create `app/Livewire/StaffRegister.php`:

```php
<?php

namespace App\Livewire;

use App\Mail\StaffRegistrationPending;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register — Non-Alumni')]
class StaffRegister extends Component
{
    public string $fname = '';
    public string $lname = '';
    public string $mname = '';
    public string $address_line_1 = '';
    public string $address_line_2 = '';
    public string $city = '';
    public string $state_province = '';
    public string $postal_code = '';
    public string $country = 'Philippines';
    public int|string $years_working = '';
    public string $position = '';
    public string $account_type = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function save(): void
    {
        $this->validate([
            'fname'               => 'required|string|max:80',
            'lname'               => 'required|string|max:80',
            'mname'               => 'nullable|string|max:80',
            'address_line_1'      => 'required|string|max:255',
            'address_line_2'      => 'nullable|string|max:255',
            'city'                => 'required|string|max:100',
            'state_province'      => 'required|string|max:100',
            'postal_code'         => 'required|string|max:20',
            'country'             => 'required|string|max:100',
            'years_working'       => 'required|integer|min:1|max:99',
            'position'            => 'required|string|max:100',
            'account_type'        => 'required|in:staff,employee,ssps-member',
            'email'               => 'required|email|max:255|unique:users,email',
            'password'            => 'required|string|min:8|confirmed',
        ]);

        $staff = null;

        DB::transaction(function () use (&$staff) {
            $staff = Staff::create([
                'fname'          => $this->fname,
                'lname'          => $this->lname,
                'mname'          => $this->mname ?: null,
                'address_line_1' => $this->address_line_1,
                'address_line_2' => $this->address_line_2 ?: null,
                'city'           => $this->city,
                'state_province' => $this->state_province,
                'postal_code'    => $this->postal_code,
                'country'        => $this->country,
                'years_working'  => (int) $this->years_working,
                'position'       => $this->position,
            ]);

            $user = User::create([
                'username'  => $this->generateUsername(),
                'email'     => $this->email,
                'password'  => Hash::make($this->password),
                'staff_id'  => $staff->id,
                'is_active' => false,
            ]);

            $user->assignRole($this->account_type);
        });

        User::role('reunion-coordinator')
            ->whereNotNull('email')
            ->get()
            ->each(fn ($coordinator) =>
                Mail::to($coordinator->email)->send(new StaffRegistrationPending($staff, $this->account_type))
            );

        $this->redirect(route('staff.pending'), navigate: true);
    }

    protected function generateUsername(): string
    {
        $base = 'staff-' . strtolower(preg_replace('/[^a-z]/i', '', $this->lname)) . strtolower(substr($this->fname, 0, 1));
        $username = $base;
        $i = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . $i++;
        }

        return $username;
    }

    public function render()
    {
        return view('livewire.staff-register');
    }
}
```

- [ ] **Step 6: Create the staff-register blade view**

Create `resources/views/livewire/staff-register.blade.php`:

```blade
<x-layouts.app :title="__('Non-Alumni Registration')">
    <div class="mx-auto max-w-2xl px-4 py-10">
        <h1 class="mb-1 text-2xl font-bold text-gray-900">Non-Alumni Registration</h1>
        <p class="mb-8 text-sm text-gray-500">For HSST employees and staff who are not alumni.</p>

        <form wire:submit="save" class="space-y-6">
            {{-- Name --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <flux:label for="fname">First Name <span class="text-red-500">*</span></flux:label>
                    <flux:input id="fname" wire:model="fname" type="text" />
                    @error('fname') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <flux:label for="lname">Last Name <span class="text-red-500">*</span></flux:label>
                    <flux:input id="lname" wire:model="lname" type="text" />
                    @error('lname') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <flux:label for="mname">Middle Name</flux:label>
                    <flux:input id="mname" wire:model="mname" type="text" />
                </div>
            </div>

            {{-- Address --}}
            <div class="space-y-4">
                <div>
                    <flux:label for="address_line_1">Address Line 1 <span class="text-red-500">*</span></flux:label>
                    <flux:input id="address_line_1" wire:model="address_line_1" type="text" />
                    @error('address_line_1') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <flux:label for="address_line_2">Address Line 2</flux:label>
                    <flux:input id="address_line_2" wire:model="address_line_2" type="text" />
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <flux:label for="city">City <span class="text-red-500">*</span></flux:label>
                        <flux:input id="city" wire:model="city" type="text" />
                        @error('city') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <flux:label for="state_province">State / Province <span class="text-red-500">*</span></flux:label>
                        <flux:input id="state_province" wire:model="state_province" type="text" />
                        @error('state_province') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <flux:label for="postal_code">Postal Code <span class="text-red-500">*</span></flux:label>
                        <flux:input id="postal_code" wire:model="postal_code" type="text" />
                        @error('postal_code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <flux:label for="country">Country <span class="text-red-500">*</span></flux:label>
                    <flux:input id="country" wire:model="country" type="text" />
                    @error('country') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Work Info --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <flux:label for="position">Position <span class="text-red-500">*</span></flux:label>
                    <flux:input id="position" wire:model="position" type="text" placeholder="e.g. Faculty, Principal" />
                    @error('position') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <flux:label for="years_working">Years Working at HSST <span class="text-red-500">*</span></flux:label>
                    <flux:input id="years_working" wire:model="years_working" type="number" min="1" max="99" />
                    @error('years_working') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Account Type --}}
            <div>
                <flux:label for="account_type">Account Type <span class="text-red-500">*</span></flux:label>
                <flux:select id="account_type" wire:model="account_type">
                    <option value="">Select type...</option>
                    <option value="staff">Staff</option>
                    <option value="employee">Employee</option>
                    <option value="ssps-member">SSPS Member</option>
                </flux:select>
                @error('account_type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Account Credentials --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <flux:label for="email">Email <span class="text-red-500">*</span></flux:label>
                    <flux:input id="email" wire:model="email" type="email" />
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <flux:label for="password">Password <span class="text-red-500">*</span></flux:label>
                    <flux:input id="password" wire:model="password" type="password" />
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <flux:label for="password_confirmation">Confirm Password <span class="text-red-500">*</span></flux:label>
                    <flux:input id="password_confirmation" wire:model="password_confirmation" type="password" />
                </div>
            </div>

            <div>
                <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                    <span wire:loading.remove>Submit Registration</span>
                    <span wire:loading>Submitting...</span>
                </flux:button>
            </div>
        </form>

        <p class="mt-6 text-sm text-gray-500">
            Are you an alumni? <a href="{{ route('login') }}" class="text-amber-600 underline">Log in here</a>.
        </p>
    </div>
</x-layouts.app>
```

- [ ] **Step 7: Run tests**

```bash
php artisan test tests/Feature/StaffRegistrationTest.php
```

Expected: all PASS

- [ ] **Step 8: Commit**

```bash
git add app/Livewire/StaffRegister.php resources/views/livewire/staff-register.blade.php resources/views/staff-pending.blade.php routes/web.php tests/Feature/StaffRegistrationTest.php
git commit -m "feat: add non-alumni self-registration flow"
```

---

## Task 6: Admin Pending Staff Component

**Files:**
- Create: `app/Livewire/Admin/PendingStaff.php`
- Create: `resources/views/livewire/admin/pending-staff.blade.php`
- Create: `tests/Feature/PendingStaffApprovalTest.php`
- Modify: `routes/web.php`

- [ ] **Step 1: Write failing tests**

Create `tests/Feature/PendingStaffApprovalTest.php`:

```php
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
    Mail::assertSent(StaffAccountApproved::class);
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
    Mail::assertSent(StaffAccountRejected::class);
});

it('non-coordinator cannot access pending staff page', function () {
    $alumni = User::factory()->create(['is_active' => true]);
    Role::firstOrCreate(['name' => 'alumni', 'guard_name' => 'web']);
    $alumni->assignRole('alumni');

    $this->actingAs($alumni)
        ->get('/admin/pending-staff')
        ->assertForbidden();
});
```

- [ ] **Step 2: Run tests to verify they fail**

```bash
php artisan test tests/Feature/PendingStaffApprovalTest.php
```

Expected: FAIL — `PendingStaff` class not found.

- [ ] **Step 3: Add route**

In `routes/web.php`, add inside the existing `auth` middleware group or alongside other admin routes:

```php
Route::get('/admin/pending-staff', \App\Livewire\Admin\PendingStaff::class)
    ->middleware(['auth', 'role:reunion-coordinator'])
    ->name('admin.pending-staff');
```

- [ ] **Step 4: Create PendingStaff Livewire component**

Create `app/Livewire/Admin/PendingStaff.php`:

```php
<?php

namespace App\Livewire\Admin;

use App\Mail\StaffAccountApproved;
use App\Mail\StaffAccountRejected;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Admin | Pending Staff Registrations')]
class PendingStaff extends Component
{
    use WithPagination;

    public function approve(int $userId): void
    {
        $user = User::whereNotNull('staff_id')->where('is_active', false)->findOrFail($userId);

        $user->update(['is_active' => true]);

        Mail::to($user->email)->send(new StaffAccountApproved($user->staff, $user->username));

        session()->flash('success', "Account approved for {$user->staff->fname} {$user->staff->lname}.");
    }

    public function reject(int $userId): void
    {
        $user = User::whereNotNull('staff_id')->where('is_active', false)->findOrFail($userId);

        $fullName = "{$user->staff->fname} {$user->staff->lname}";
        $email = $user->email;

        $user->staff->delete();

        Mail::to($email)->send(new StaffAccountRejected($fullName));

        session()->flash('success', "Registration for {$fullName} has been rejected and removed.");
    }

    public function render()
    {
        $pending = User::whereNotNull('staff_id')
            ->where('is_active', false)
            ->with('staff')
            ->latest()
            ->paginate(15);

        return view('livewire.admin.pending-staff', ['pending' => $pending]);
    }
}
```

- [ ] **Step 5: Create the blade view**

Create `resources/views/livewire/admin/pending-staff.blade.php`:

```blade
<div>
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Pending Non-Alumni Registrations</h1>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800">{{ session('success') }}</div>
    @endif

    @if ($pending->isEmpty())
        <div class="rounded-lg border border-dashed border-gray-300 p-10 text-center text-gray-500">
            No pending registrations.
        </div>
    @else
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Position</th>
                        <th class="px-4 py-3 text-left">Type</th>
                        <th class="px-4 py-3 text-left">Years at HSST</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Registered</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($pending as $user)
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $user->staff->fname }} {{ $user->staff->lname }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->staff->position }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">
                                    {{ $user->getRoleNames()->first() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->staff->years_working }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <flux:button
                                        size="sm"
                                        variant="primary"
                                        wire:click="approve({{ $user->id }})"
                                        wire:confirm="Approve this registration?"
                                    >Approve</flux:button>
                                    <flux:button
                                        size="sm"
                                        variant="danger"
                                        wire:click="reject({{ $user->id }})"
                                        wire:confirm="Reject and delete this registration?"
                                    >Reject</flux:button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $pending->links() }}</div>
    @endif
</div>
```

- [ ] **Step 6: Run tests**

```bash
php artisan test tests/Feature/PendingStaffApprovalTest.php
```

Expected: all PASS

- [ ] **Step 7: Commit**

```bash
git add app/Livewire/Admin/PendingStaff.php resources/views/livewire/admin/pending-staff.blade.php routes/web.php tests/Feature/PendingStaffApprovalTest.php
git commit -m "feat: add admin pending staff approval component"
```

---

## Task 7: Staff Dashboard + Navigation Link

**Files:**
- Create: `resources/views/livewire/staff-dashboard.blade.php`
- Modify: `resources/views/dashboard.blade.php`

- [ ] **Step 1: Create staff dashboard view**

Create `resources/views/livewire/staff-dashboard.blade.php`:

```blade
<div>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">Welcome, {{ auth()->user()->staff->fname }}!</h2>
        <p class="text-sm text-gray-500">Use this page to signify your attendance at the HSST Reunion 2026.</p>
    </div>

    <livewire:upcoming-events />
</div>
```

- [ ] **Step 2: Update dashboard.blade.php**

In `resources/views/dashboard.blade.php`, add the staff dashboard include after the existing `@can` blocks:

```blade
<x-layouts.app :title="__('Dashboard')">
    @if(app()->environment('local'))
        {{-- debug block unchanged --}}
    @endif
        @can('view.admin.dashboard')
        <livewire:dashboard/>
        @endcan
        @can('view.alumni.dashboard')
          <livewire:alumni-dashboard/>
        @endcan
        @can('view.batchRep.dashboard')
        <livewire:batch-rep-dashboard/>
        @endcan
        @can('view.staff.dashboard')
        @include('livewire.staff-dashboard')
        @endcan
</x-layouts.app>
```

- [ ] **Step 3: Add Pending Staff link to coordinator nav (if sidebar exists)**

Search for where admin navigation links live:

```bash
grep -r "password-reset-requests" resources/views --include="*.blade.php" -l
```

Open the file found and add a link to `/admin/pending-staff` near the password reset requests link:

```blade
<flux:navlist.item href="{{ route('admin.pending-staff') }}" :current="request()->routeIs('admin.pending-staff')">
    Pending Registrations
</flux:navlist.item>
```

- [ ] **Step 4: Run full test suite**

```bash
php artisan test
```

Expected: all tests PASS

- [ ] **Step 5: Commit**

```bash
git add resources/views/livewire/staff-dashboard.blade.php resources/views/dashboard.blade.php
git commit -m "feat: add staff dashboard view and update dashboard routing"
```

---

## Self-Review

**Spec coverage check:**
- Staff table + model ✓ Task 1
- staff_id on users + User model ✓ Task 2
- New roles (staff/employee/ssps-member) + permission ✓ Task 3
- Email mailables (pending/approved/rejected) ✓ Task 4
- Self-registration form + route ✓ Task 5
- Pending approval page after register ✓ Task 5
- Coordinator notified on registration ✓ Task 5 (StaffRegister.save())
- Admin approve/reject component ✓ Task 6
- Approval email to user ✓ Task 6
- Rejection email + record deletion ✓ Task 6
- Staff dashboard view ✓ Task 7
- dashboard.blade.php updated ✓ Task 7
- Coordinator nav link ✓ Task 7 Step 3

**No placeholders found.**

**Type consistency:** `StaffAccountApproved` receives `Staff $staff, string $username` — matches instantiation in `PendingStaff::approve()`. `StaffAccountRejected` receives `string $fullName` — matches instantiation in `PendingStaff::reject()`. `StaffRegistrationPending` receives `Staff $staff, string $accountType` — matches instantiation in `StaffRegister::save()`. All consistent.
