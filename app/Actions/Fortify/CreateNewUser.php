<?php

namespace App\Actions\Fortify;

use App\Models\Alumni;
use App\Models\AlumniEducation;
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
                $alumni = $this->createAlumni($validated);
                $this->createEducationRecords($alumni, $validated);
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

            'cellphone' => ['required', 'string', 'min:11', 'max:15'],
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

            'educations' => ['required', 'array'],
            'educations.elementary.enabled' => ['nullable', 'boolean'],
            'educations.highschool.enabled' => ['nullable', 'boolean'],
            'educations.college.enabled' => ['nullable', 'boolean'],

            'educations.elementary.did_graduate' => ['nullable', 'boolean'],
            'educations.highschool.did_graduate' => ['nullable', 'boolean'],
            'educations.college.did_graduate' => ['nullable', 'boolean'],

            'educations.elementary.batch_id' => ['nullable', 'integer', 'exists:batches,id'],
            'educations.highschool.batch_id' => ['nullable', 'integer', 'exists:batches,id'],
            'educations.college.batch_id' => ['nullable', 'integer', 'exists:batches,id'],

            'educations.elementary.school_year_attended' => ['nullable', 'string', 'max:50'],
            'educations.highschool.school_year_attended' => ['nullable', 'string', 'max:50'],
            'educations.college.school_year_attended' => ['nullable', 'string', 'max:50'],

            'volunteer_interest' => ['nullable', 'in:yes,later'],
            'committees' => ['nullable', 'array'],
            'committees.*' => ['integer', 'exists:committees,id'],
            'volunteer_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $validator->after(function ($validator) use ($input) {
            $levels = ['elementary', 'highschool', 'college'];
            $selectedCount = 0;

            foreach ($levels as $level) {
                $education = $input['educations'][$level] ?? [];
                $enabled = filter_var($education['enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);

                if (! $enabled) {
                    continue;
                }

                $selectedCount++;

                $batchId = $education['batch_id'] ?? null;
                $didGraduate = array_key_exists('did_graduate', $education)
                    ? filter_var($education['did_graduate'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                    : null;

                $schoolYearAttended = $education['school_year_attended'] ?? null;

                if (empty($batchId)) {
                    $validator->errors()->add("educations.$level.batch_id", "Please select a batch for {$level}.");
                    continue;
                }

                $batch = Batch::find($batchId);

                if (! $batch) {
                    $validator->errors()->add("educations.$level.batch_id", "Selected batch for {$level} is invalid.");
                    continue;
                }

                if ($batch->level !== $level) {
                    $validator->errors()->add("educations.$level.batch_id", "Selected batch does not match the {$level} level.");
                }

                if ($didGraduate === null) {
                    $validator->errors()->add("educations.$level.did_graduate", "Please indicate whether you graduated for {$level}.");
                }

                if ($didGraduate === false && empty($schoolYearAttended)) {
                    $validator->errors()->add("educations.$level.school_year_attended", "School year attended is required for {$level} if you did not graduate.");
                }
            }

            if ($selectedCount === 0) {
                $validator->errors()->add('educations', 'Please include at least one alumni level.');
            }

            if (($input['volunteer_interest'] ?? 'later') === 'yes' && empty($input['committees'])) {
                $validator->errors()->add('committees', 'Please choose at least one committee if you want to volunteer.');
            }
        });

        return $validator->validate();
    }

    /**
     * @param array<string, mixed> $validated
     */
    protected function createAlumni(array $validated): Alumni
    {
        return Alumni::create([
            'prefix' => $validated['prefix'] ?? null,
            'fname' => $validated['fname'],
            'mname' => $validated['mname'] ?? null,
            'lname' => $validated['lname'],
            'suffix' => $validated['suffix'] ?? null,

            'occupation' => $validated['occupation'] ?? null,
            'cellphone' => $validated['cellphone'],

            'address_line_1' => $validated['address_line_1'],
            'address_line_2' => $validated['address_line_2'] ?? null,
            'city' => $validated['city'],
            'state_province' => $validated['state_province'],
            'postal_code' => $validated['postal_code'] ?? null,
            'country' => $validated['country'],
        ]);
    }

    /**
     * @param array<string, mixed> $validated
     */
    protected function createEducationRecords(Alumni $alumni, array $validated): void
    {
        $levels = ['elementary', 'highschool', 'college'];

        foreach ($levels as $level) {
            $education = $validated['educations'][$level] ?? [];
            $enabled = filter_var($education['enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);

            if (! $enabled) {
                continue;
            }

            $didGraduate = filter_var($education['did_graduate'] ?? true, FILTER_VALIDATE_BOOLEAN);

            AlumniEducation::create([
                'alumni_id' => $alumni->id,
                'batch_id' => (int) $education['batch_id'],
                'did_graduate' => $didGraduate,
                'school_year_attended' => $didGraduate ? null : ($education['school_year_attended'] ?? null),
                'is_batch_rep' => false, // public registration cannot assign batch rep
            ]);
        }
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
            'education_levels' => array_keys(array_filter($input['educations'] ?? [], function ($education) {
                return filter_var($education['enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);
            })),
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
            $input['email'] = strtolower(trim($input['email']));
        }

        foreach ([
            'prefix',
            'mname',
            'suffix',
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

        if (! isset($input['educations']) || ! is_array($input['educations'])) {
            $input['educations'] = [];
        }

        foreach (['elementary', 'highschool', 'college'] as $level) {
            $education = $input['educations'][$level] ?? [];

            if (! is_array($education)) {
                $education = [];
            }

            foreach (['school_year_attended'] as $field) {
                if (array_key_exists($field, $education) && is_string($education[$field])) {
                    $education[$field] = trim($education[$field]);
                }
            }

            $education['enabled'] = filter_var($education['enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $education['did_graduate'] = array_key_exists('did_graduate', $education)
                ? filter_var($education['did_graduate'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                : null;

            if (($education['school_year_attended'] ?? '') === '') {
                $education['school_year_attended'] = null;
            }

            if (($education['batch_id'] ?? '') === '') {
                $education['batch_id'] = null;
            }

            // Never trust public registration for batch rep assignment
            unset($education['is_batch_rep']);

            if ($education['did_graduate'] === true) {
                $education['school_year_attended'] = null;
            }

            $input['educations'][$level] = $education;
        }

        return $input;
    }
}