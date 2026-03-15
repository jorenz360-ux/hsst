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

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/event-registrations/{registration}/payment', EventRegistrationPaymentPage::class)
    ->middleware(['auth'])
    ->name('event-registration.payment');

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

Route::get('/events', \App\Livewire\PublicEvents::class);

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



require __DIR__.'/settings.php';
