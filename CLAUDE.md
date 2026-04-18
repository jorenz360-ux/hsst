# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

HSST Reunion 2026 is a Laravel 12 + Livewire 3 alumni management web app for Holy Spirit School of Tagbilaran (HSST). It handles alumni registration, event management, donations with PayMongo payment processing, and role-based access control.

## Commands

```bash
# First-time setup
composer setup          # install deps, generate key, migrate, npm build

# Development (runs server + queue worker + Vite concurrently)
composer dev

# Production build
npm run build

# Run all tests
composer test

# Run a single test file
php artisan test tests/Feature/ExampleTest.php

# Run tests matching a name
php artisan test --filter=ExampleTest

# Code formatting (Laravel Pint)
./vendor/bin/pint

# Database
php artisan migrate
php artisan db:seed
php artisan tinker
```

## Architecture

### Authentication & Roles

Authentication is handled by **Laravel Fortify** (configured in `app/Providers/FortifyServiceProvider.php`). Authorization uses **Spatie Permission** with four roles:

- `reunion-coordinator` — full admin access
- `ssps` — event/announcement management
- `batch-representative` — batch-level reporting and donations
- `alumni` — event participation and donations

Role guards are applied directly on routes in `routes/web.php`. The `EnsureUserIsActive` middleware (`app/Http/Middleware/`) gates all authenticated routes.

### UI Architecture

All interactive pages are **Livewire 3 components** in `app/Livewire/`. Views live in `resources/views/livewire/`. The UI uses **Flux** (Livewire's component library) and **Tailwind CSS 4**. Single-file Volt components are also used (configured via `VoltServiceProvider`).

The `dashboard` route renders `resources/views/dashboard.blade.php`, which uses role-conditional includes to show different content per role.

### Payment Flow

PayMongo handles all payments. `app/Services/PayMongoService.php` creates checkout sessions. The webhook at `POST /webhook/paymongo` → `PayMongoWebhookController` processes payment confirmations and updates `EventRegistration` and `Donation` records.

### Key Models & Relationships

- `User` → has one `Alumni`, has roles via Spatie
- `Alumni` → belongs to `Batch`, has many `EventRegistration`, `Donation`
- `Event` → has many `EventRegistrationItem` (selectable items), `EventRegistration`
- `EventRegistration` → belongs to `Alumni` + `Event`, tracks payment status
- `Donation` → belongs to `Alumni`, linked to `Payment`

### File Storage

Production uses **AWS S3** as the default filesystem disk. Profile photos and uploads go through S3.

### Queue & Sessions

Both the queue driver and session driver are database-backed (see `.env`). The queue worker must be running during development — `composer dev` starts it automatically.

### Testing

Tests use SQLite in-memory (configured in `phpunit.xml`). Pest 4 is the test runner. Test files live in `tests/Feature/` and `tests/Unit/`.
