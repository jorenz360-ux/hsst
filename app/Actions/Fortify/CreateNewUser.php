<?php

namespace App\Actions\Fortify;

use App\Models\Alumni;
use App\Models\Batch;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Throwable;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array<string, string> $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class, 'username')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'password' => $this->passwordRules(),

            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],

            'yeargrad' => ['required', 'integer', 'min:1900', 'max:' . now()->year],
        ])->validate();

        try {

            return DB::transaction(function () use ($input) {

                $yeargrad = (int) $input['yeargrad'];
                $schoolyear = ($yeargrad - 1) . '-' . $yeargrad;

                $batch = Batch::firstOrCreate(
                    ['yeargrad' => $yeargrad],
                    ['schoolyear' => $schoolyear]
                );

                $alumni = Alumni::create([
                    'fname' => $input['fname'],
                    'mname' => $input['mname'] ?? null,
                    'lname' => $input['lname'],
                    'batch_id' => $batch->id,
                    'is_batch_rep' => false,
                ]);

                $user = User::create([
                    'username' => $input['username'],
                    'email' => $input['email'],
                    'password' => $input['password'], // hash if not auto-hashed
                    'alumni_id' => $alumni->id,
                ]);

                $user->assignRole('alumni');

                return $user;
            });

        } catch (Throwable $e) {

            // Log error for production debugging
            Log::error('Alumni registration failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $input
            ]);

            // Show error in local development
            if (config('app.debug')) {
                dd('Registration error', $e->getMessage(), $e);
            }

            throw $e;
        }
    }
}