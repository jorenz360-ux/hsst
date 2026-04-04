<?php

namespace App\Actions\Fortify;

use App\Models\Alumni;
use App\Models\Batch;
use App\Models\Committee;
use App\Models\User;
use App\Models\VolunteerSignup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
     * @param array<string, mixed> $input
     */
    public function create(array $input): User
    {
        $input = $this->sanitizeInput($input);
        $validated = $this->validateInput($input);

        try {
            return DB::transaction(function () use ($validated): User {
                $batch = $this->resolveBatch($validated);
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
        if (($validated['volunteer_interest'] ?? 'later') !== 'yes') {
            return;
        }

        if (empty($validated['committees']) || ! is_array($validated['committees'])) {
            return;
        }

        foreach ($validated['committees'] as $committeeId) {
            $committee = Committee::find($committeeId);

            if (! $committee) {
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
        $validator = Validator::make($input, [
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

            'prefix' => ['nullable', 'string', 'max:20'],
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:20'],

            'cellphone' => ['required', 'string', 'max:30'],
            'educational_level' => ['required', Rule::in(['elementary', 'high_school', 'college'])],
            'did_graduate' => ['required', 'boolean'],

            'yeargrad' => ['nullable', 'integer', 'min:1900', 'max:' . now()->year],
            'school_year_attended' => ['nullable', 'string', 'max:50'],

            'occupation' => ['nullable', 'string', 'max:255'],

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
            'committees.*' => ['integer', 'exists:committees,id'],
            'volunteer_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $validator->after(function ($validator) use ($input) {
            $didGraduate = array_key_exists('did_graduate', $input)
                ? filter_var($input['did_graduate'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                : null;

            if ($didGraduate === true && empty($input['yeargrad'])) {
                $validator->errors()->add('yeargrad', 'Year graduated is required if you graduated from HSST.');
            }

            if ($didGraduate === false && empty($input['school_year_attended'])) {
                $validator->errors()->add('school_year_attended', 'School year attended is required if you did not graduate from HSST.');
            }

            if (($input['volunteer_interest'] ?? 'later') === 'yes' && empty($input['committees'])) {
                $validator->errors()->add('committees', 'Please choose at least one committee if you want to volunteer.');
            }
        });

        return $validator->validate();
    }

    protected function resolveBatch(array $validated): ?Batch
    {
        $didGraduate = filter_var($validated['did_graduate'] ?? false, FILTER_VALIDATE_BOOLEAN);

        if ($didGraduate && ! empty($validated['yeargrad'])) {
            return $this->createOrGetBatch((int) $validated['yeargrad']);
        }

        return null;
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
    protected function createAlumni(array $validated, ?Batch $batch): Alumni
    {
        $didGraduate = filter_var($validated['did_graduate'], FILTER_VALIDATE_BOOLEAN);

        return Alumni::create([
            'prefix' => $validated['prefix'] ?? null,
            'fname' => $validated['fname'],
            'mname' => $validated['mname'] ?? null,
            'lname' => $validated['lname'],
            'suffix' => $validated['suffix'] ?? null,

            'batch_id' => $batch?->id,
            'is_batch_rep' => false,

            'occupation' => $validated['occupation'] ?? null,
            'cellphone' => $validated['cellphone'],
            'educational_level' => $validated['educational_level'],
            'did_graduate' => $didGraduate,
            'school_year_attended' => $didGraduate ? null : ($validated['school_year_attended'] ?? null),

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
            'school_year_attended' => $input['school_year_attended'] ?? null,
            'educational_level' => $input['educational_level'] ?? null,
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
            'prefix',
            'fname',
            'mname',
            'lname',
            'suffix',
            'cellphone',
            'educational_level',
            'school_year_attended',
            'occupation',
            'address_line_1',
            'address_line_2',
            'city',
            'state_province',
            'postal_code',
            'country',
            'formatted_address',
            'place_id',
            'volunteer_interest',
            'volunteer_notes',
        ];

        foreach ($fieldsToTrim as $field) {
            if (array_key_exists($field, $input) && is_string($input[$field])) {
                $input[$field] = trim($input[$field]);
            }
        }

        if (isset($input['email']) && is_string($input['email'])) {
            $input['email'] = strtolower($input['email']);
        }

        if (array_key_exists('did_graduate', $input)) {
            $input['did_graduate'] = filter_var($input['did_graduate'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        }

        foreach ([
            'prefix',
            'mname',
            'suffix',
            'school_year_attended',
            'occupation',
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

        if (($input['did_graduate'] ?? null) === true) {
            $input['school_year_attended'] = null;
        }

        if (($input['did_graduate'] ?? null) === false) {
            $input['yeargrad'] = null;
        }

        return $input;
    }
}