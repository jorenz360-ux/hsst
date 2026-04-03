<?php

namespace App\Actions\Fortify;

use App\Models\Alumni;
use App\Models\Batch;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Throwable;
use App\Models\Committee;
use App\Models\VolunteerSignup;
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array<string, mixed> $input
     */
    public function create(array $input): User
    {
        $input = $this->sanitizeInput($input);
        $validated = $this->validateInput($input);

        try {
            return DB::transaction(function () use ($validated): User {
                $batch = $this->createOrGetBatch((int) $validated['yeargrad']);
                $alumni = $this->createAlumni($validated, $batch);
                $user = $this->createUserAccount($validated, $alumni);

                $user->assignRole('alumni');
                $this->handleVolunteerSignup($validated, $user, $alumni);
                return $user;
            }, 3);
        } catch (Throwable $e) {
            $this->logRegistrationFailure($e, $input);
            throw $e;
        }
    }
protected function handleVolunteerSignup(array $validated, User $user, Alumni $alumni): void
{
    // If not interested → skip
    if (($validated['volunteer_interest'] ?? 'later') !== 'yes') {
        return;
    }

    // If no committees selected → skip
    if (empty($validated['committees'])) {
        return;
    }

   foreach ($validated['committees'] as $committeeId) {

    $committee = Committee::find($committeeId);

    if (!$committee) {
        continue;
    }

    VolunteerSignup::create([
        'user_id' => $user->id,
        'alumni_id' => $alumni->id,
        'committee_id' => $committee->id,
        'notes' => $validated['volunteer_notes'] ?? null,
        'status' => 'pending',
    ]);
}
}
    /**
     * @param array<string, mixed> $input
     * @return array<string, mixed>
     */
    protected function validateInput(array $input): array
    {
        return Validator::make($input, [
            'username' => [
                'required',
                'string', 
                'max:255',
                Rule::unique(User::class, 'username'),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'email'),
            ],
            'password' => $this->passwordRules(),

            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],

            'occupation' => ['nullable', 'string', 'max:255'],

            'yeargrad' => ['required', 'integer', 'min:1900', 'max:' . now()->year],

            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'state_province' => ['required', 'string', 'max:120'],
            'postal_code' => ['nullable', 'string', 'max:30'],
            'country' => ['required', 'string', 'max:100'],

            'formatted_address' => ['nullable', 'string'],
            'place_id' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],

            'volunteer_interest' => ['nullable', 'in:yes,later'],
            'committees' => ['nullable', 'array'],
            'committees.*' => ['string', 'max:150'],
            'volunteer_notes' => ['nullable', 'string', 'max:1000'],
        ])->validate();
    }

    protected function createOrGetBatch(int $yeargrad): Batch
    {
        return Batch::firstOrCreate(
            ['yeargrad' => $yeargrad],
            ['schoolyear' => ($yeargrad - 1) . '-' . $yeargrad]
        );
    }

    /**
     * @param array<string, mixed> $validated
     */
    protected function createAlumni(array $validated, Batch $batch): Alumni
    {
        return Alumni::create([
            'fname' => $validated['fname'],
            'mname' => $validated['mname'] ?? null,
            'lname' => $validated['lname'],
            'batch_id' => $batch->id,
            'is_batch_rep' => false,

            'occupation' => $validated['occupation'] ?? null,

            'address_line_1' => $validated['address_line_1'],
            'address_line_2' => $validated['address_line_2'] ?? null,
            'city' => $validated['city'],
            'state_province' => $validated['state_province'],
            'postal_code' => $validated['postal_code'] ?? null,
            'country' => $validated['country'],

            'formatted_address' => $validated['formatted_address'] ?? null,
            'place_id' => $validated['place_id'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ]);
    }

    /**
     * @param array<string, mixed> $validated
     */
    protected function createUserAccount(array $validated, Alumni $alumni): User
    {
        return User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'alumni_id' => $alumni->id,
        ]);
    }

    protected function logRegistrationFailure(Throwable $e, array $input): void
    {
        Log::error('Alumni registration failed', [
            'message' => $e->getMessage(),
            'username' => $input['username'] ?? null,
            'email' => $input['email'] ?? null,
            'yeargrad' => $input['yeargrad'] ?? null,
        ]);
    }

    /**
     * Normalize incoming registration input.
     *
     * @param array<string, mixed> $input
     * @return array<string, mixed>
     */
    protected function sanitizeInput(array $input): array
    {
        $fieldsToTrim = [
            'username',
            'email',
            'fname',
            'mname',
            'lname',
            
            'occupation',

            'address_line_1',
            'address_line_2',
            'city',
            'state_province',
            'postal_code',
            'country',
            'formatted_address',
            'place_id',
        ];

        foreach ($fieldsToTrim as $field) {
            if (array_key_exists($field, $input) && is_string($input[$field])) {
                $input[$field] = trim($input[$field]);
            }
        }

        if (isset($input['email']) && is_string($input['email'])) {
            $input['email'] = strtolower($input['email']);
        }

        foreach ([
            'mname',
            'address_line_2',
            'postal_code',
            'formatted_address',
            'place_id',
            'latitude',
            'longitude',
        ] as $nullableField) {
            if (array_key_exists($nullableField, $input) && $input[$nullableField] === '') {
                $input[$nullableField] = null;
            }
        }

        return $input;
    }
}