<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PayMongoWebhookController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\Welcome;
use App\Livewire\Admin\PasswordResetRequests;
use App\Livewire\AttendanceReport;
use App\Livewire\Batch;
use App\Livewire\BatchRepReports;
use App\Livewire\CommitteReport;
use App\Livewire\CreateEvents;
use App\Livewire\CreateUser;
use App\Livewire\Donations;
use App\Livewire\EventParticipationPage;
use App\Livewire\EventPayment;
use App\Livewire\EventRegistrationPaymentPage;
use App\Livewire\Events;
use App\Livewire\MakeDonations;
use App\Livewire\ManageAnnouncement;
use App\Livewire\ManageDonations;
use App\Livewire\ManageUsers;
use App\Livewire\Reports;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/password-reset-requests', PasswordResetRequests::class)
        ->middleware(['auth', 'role:reunion-coordinator|super-admin'])
        ->name('admin.password-reset-requests');
});
Route::get('/attendace-reports', AttendanceReport::class)
    ->middleware(['auth', 'role:reunion-coordinator|super-admin'])
    ->name('reports.attendance');

Route::get('/committe-reports', CommitteReport::class)
    ->middleware(['auth', 'role:reunion-coordinator|super-admin'])
    ->name('reports.committe');

Route::get('/batch-reports', BatchRepReports::class)
    ->middleware(['auth', 'role:batch-representative|super-admin'])
    ->name('reports.batch-rep');

Route::get('/alumni/events/{event}', EventParticipationPage::class)
    ->middleware(['auth'])
    ->name('alumni.events.show');

Route::get('/history', [HistoryController::class, 'index'])->name('history');

Route::get('/view-batch', Batch::class)
    ->middleware(['auth', 'role:batch-representative|super-admin'])
    ->name('view-batch');

Route::get('/view-donations', Donations::class)
    ->middleware(['auth', 'role:reunion-coordinator|super-admin'])
    ->name('view-donations');

Route::get('/events', [PublicEventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [PublicEventController::class, 'show'])->name('events.show');

Route::get('/', [Welcome::class, 'index'])->name('home');
Route::view('/privacy', 'privacy')->name('privacy');

// Route::get('/alumni/events/{event}', EventRegistrationPaymentPage::class)
//     ->name('alumni.events.show');

Route::get('/about-us', function () {
    return view('public/about-us');
})->name('about-us');

Route::get('/event-registrations/{registration}/pay', EventPayment::class)
    ->middleware(['auth', 'role:alumni|batch-representative'])
    ->name('event-registrations.pay');

Route::get('/make-donations', MakeDonations::class)
    ->middleware(['auth', 'role:alumni'])
    ->name('make-donations');

Route::get('/events/{event}/edit', \App\Livewire\EditEvent::class)
    ->middleware(['auth', 'verified', 'can:edit.event'])
    ->name('events.edit');

Route::get(uri: '/announcement', action: ManageAnnouncement::class)
    ->middleware(['auth', 'role:ssps|reunion-coordinator|super-admin'])
    ->name('manage-announcement');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'role:reunion-coordinator|ssps|alumni|batch-representative|staff|employee|ssps-member|super-admin'])
    ->name('dashboard');

Route::get('/manage-users', ManageUsers::class)
    ->middleware(['auth', 'verified', 'role:reunion-coordinator|ssps|super-admin'])
    ->name('manage-users');

Route::get('/users/create', CreateUser::class)
    ->middleware(['auth', 'role:reunion-coordinator|ssps|super-admin'])
    ->name('users.create');
Route::get('/reports', Reports::class)
    ->middleware(['auth', 'role:reunion-coordinator|ssps|batch-representative|super-admin'])
    ->name('reports');
Route::get('/donations', ManageDonations::class)
    ->middleware(['auth', 'role:batch-representative|cashier|super-admin'])
    ->name('donations');

Route::get(uri: '/create/events', action: CreateEvents::class)
    ->middleware(['auth', 'role:ssps|reunion-coordinator|super-admin'])
    ->name('create-event');

Route::get(uri: '/view/events', action: Events::class)
    ->middleware(['auth', 'role:ssps|reunion-coordinator|super-admin'])
    ->name('event-view');

Route::post('/webhook/paymongo', [PayMongoWebhookController::class, 'handle']);

Route::get('/register/staff', \App\Livewire\StaffRegister::class)
    ->middleware(['throttle:6,1'])
    ->name('register.staff');
Route::post('/register/staff', [\App\Http\Controllers\StaffRegisterController::class, 'store'])
    ->middleware(['throttle:6,1'])
    ->name('register.staff.store');
Route::view('/staff/pending', 'staff-pending')->name('staff.pending');

Route::get('/admin/pending-staff', \App\Livewire\Admin\PendingStaff::class)
    ->middleware(['auth', 'role:reunion-coordinator|super-admin'])
    ->name('admin.pending-staff');

require __DIR__.'/settings.php';
