<?php

use App\Livewire\CreateEvents;
use App\Livewire\Events;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Livewire\ManageUsers;
use App\Livewire\CreateUser;
use App\Livewire\ManageDonations;
use App\Livewire\Reports;
use App\Livewire\MakeDonations;
use App\Http\Controllers\PayMongoWebhookController;
use App\Livewire\Announcement;
use App\Livewire\ManageAnnouncement;
use App\Livewire\EventRegistrationPaymentPage;
use App\Livewire\EventPayment;
use App\Livewire\Batch;
use App\Http\Controllers\PublicEventController;
use App\Livewire\Donations;
use App\Http\Controllers\Welcome;

use App\Http\Controllers\HistoryController;
use App\Livewire\BatchRepReports;
use App\Livewire\EventParticipationPage;
use App\Livewire\CommitteReport;
use App\Livewire\AttendanceReport;
use App\Livewire\Admin\PasswordResetRequests;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/password-reset-requests', PasswordResetRequests::class)   
        ->middleware(['auth', 'role:reunion-coordinator'])
        ->name('admin.password-reset-requests');
});
Route::get('/attendace-reports', AttendanceReport::class)
    ->middleware(['auth', 'role:reunion-coordinator'])
    ->name('reports.attendance');

Route::get('/committe-reports', CommitteReport::class)
    ->middleware(['auth', 'role:reunion-coordinator'])
    ->name('reports.committe');

Route::get('/batch-reports', BatchRepReports::class)
    ->middleware(['auth', 'role:batch-representative'])
    ->name('reports.batch-rep');

Route::get('/alumni/events/{event}', EventParticipationPage::class)
    ->middleware(['auth'])
    ->name('alumni.events.show');

Route::get('/history', [HistoryController::class, 'index'])->name('history');

Route::get('/view-batch', Batch::class)
    ->middleware(['auth', 'role:batch-representative'])
    ->name('view-batch');

Route::get('/view-donations', Donations::class)
    ->middleware(['auth', 'role:reunion-coordinator'])
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
    ->middleware(['auth', 'role:alumni'])
    ->name('event-registrations.pay');

Route::get('/make-donations', MakeDonations::class)
    ->middleware(['auth', 'role:alumni'])
    ->name('make-donations');


Route::get('/events/{event}/edit', \App\Livewire\EditEvent::class)
    ->middleware(['auth', 'verified', 'can:edit.event'])
    ->name('events.edit');


Route::get(uri:'/announcement', action: ManageAnnouncement::class)
    ->middleware(['auth', 'role:ssps|reunion-coordinator'])
    ->name('manage-announcement');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified','role:reunion-coordinator|ssps|alumni|batch-representative'])
    ->name('dashboard');

Route::get('/manage-users', ManageUsers::class)
    ->middleware(['auth', 'verified', 'role:reunion-coordinator|ssps'])
    ->name('manage-users');

Route::get('/users/create', CreateUser::class)
    ->middleware(['auth', 'role:reunion-coordinator|ssps'])
    ->name('users.create');
Route::get('/reports', Reports::class)
    ->middleware(['auth', 'role:reunion-coordinator|ssps|batch-representative'])
    ->name('reports');
Route::get('/donations', ManageDonations::class)
    ->middleware(['auth', 'role:batch-representative'])
    ->name('donations');

Route::get(uri:'/create/events', action: CreateEvents::class)
    ->middleware(['auth', 'role:ssps|reunion-coordinator'])
    ->name('create-event');
    
Route::get(uri:'/view/events', action: Events::class)
    ->middleware(['auth', 'role:ssps|reunion-coordinator'])
    ->name('event-view');
    
Route::post('/webhook/paymongo', [PayMongoWebhookController::class, 'handle']);



Route::get('/register/staff', \App\Livewire\StaffRegister::class)->name('register.staff');
Route::view('/staff/pending', 'staff-pending')->name('staff.pending');

require __DIR__.'/settings.php';
