<?php

namespace App\Livewire;

use App\Mail\WelcomeCredentials;
use App\Models\Alumni;
use App\Models\AlumniEducation;
use App\Models\Batch;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Add User')]
class CreateUser extends Component
{
    const STAFF_ROLES = ['cashier'];

    // User type toggle
    public string $userType = 'alumni'; // 'alumni' | 'staff'
    public string $staffRole = '';

    // Alumni / shared fields
    public string $lname = '';
    public string $fname = '';
    public string $mname = '';
    public string $email = '';

    // Alumni-only education fields
    public ?int $batch_id = null;
    public bool $is_batch_rep = false;
    public bool $did_graduate = true;
    public string $school_year_attended = '';

    public function getBatchesProperty()
    {
        $levelOrder = ['elementary' => 0, 'highschool' => 1, 'college' => 2];

        return Batch::query()
            ->orderByDesc('yeargrad')
            ->get()
            ->sortBy(fn ($b) => $levelOrder[$b->level] ?? 99)
            ->groupBy('level');
    }

    public function getBatchHasRepProperty(): bool
    {
        if (blank($this->batch_id)) return false;

        return AlumniEducation::where('batch_id', $this->batch_id)
            ->where('is_batch_rep', true)
            ->exists();
    }

    public function updatedBatchId(): void
    {
        if ($this->batchHasRep) {
            $this->is_batch_rep = false;
        }
    }

    public function updatedUserType(): void
    {
        $this->reset([
            'batch_id', 'is_batch_rep', 'did_graduate', 'school_year_attended',
            'staffRole',
        ]);
        $this->resetValidation();
    }

    public function resetForm(): void
    {
        $this->reset([
            'userType', 'staffRole',
            'lname', 'fname', 'mname', 'email',
            'batch_id', 'is_batch_rep', 'did_graduate', 'school_year_attended',
        ]);
    }

    public function save(): void
    {
        if ($this->userType === 'staff') {
            $this->saveStaff();
        } else {
            $this->saveAlumni();
        }
    }

    private function saveStaff(): void
    {
        $this->validate([
            'lname'     => 'required|string|max:80',
            'fname'     => 'required|string|max:80',
            'mname'     => 'nullable|string|max:80',
            'email'     => 'required|email|max:255|unique:users,email',
            'staffRole' => ['required', Rule::in(self::STAFF_ROLES)],
        ]);

        $username          = $this->generateStaffUsername();
        $temporaryPassword = $this->generateTempPassword();

        DB::transaction(function () use ($username, $temporaryPassword) {
            // Staff record is required so User::getNameAttribute() resolves the display
            // name via $this->staff rather than falling back to the raw username.
            // Address/position columns are nullable for system-created accounts (see migration
            // 2026_04_26_044807_make_staff_contact_fields_nullable).
            $staff = Staff::create([
                'fname' => $this->fname,
                'lname' => $this->lname,
                'mname' => $this->mname ?: null,
            ]);

            $user = User::create([
                'username'             => $username,
                'password'             => Hash::make($temporaryPassword),
                'must_change_password' => true,
                'email'                => $this->email,
                'staff_id'             => $staff->id,
            ]);

            $user->syncRoles([$this->staffRole]);
        });

        $fullName = trim("{$this->fname} {$this->lname}");
        Mail::to($this->email)->send(new WelcomeCredentials($fullName, $username, $temporaryPassword));

        session()->flash('success', ucfirst($this->staffRole) . " account created. Credentials sent to {$this->email}.");

        $this->resetForm();
    }

    private function saveAlumni(): void
    {
        $this->validate([
            'lname'                => 'required|string|max:80',
            'fname'                => 'required|string|max:80',
            'mname'                => 'nullable|string|max:80',
            'email'                => 'required|email|max:255|unique:users,email',
            'batch_id'             => 'required|exists:batches,id',
            'is_batch_rep'         => 'boolean',
            'did_graduate'         => 'boolean',
            'school_year_attended' => 'nullable|string|max:50',
        ]);

        $username          = $this->generateAlumniUsername();
        $temporaryPassword = $this->generateTempPassword();

        DB::transaction(function () use ($username, $temporaryPassword) {
            if ($this->is_batch_rep) {
                AlumniEducation::where('batch_id', $this->batch_id)
                    ->where('is_batch_rep', true)
                    ->update(['is_batch_rep' => false]);
            }

            $alumni = Alumni::create([
                'lname' => $this->lname,
                'fname' => $this->fname,
                'mname' => $this->mname ?: null,
            ]);

            AlumniEducation::create([
                'alumni_id'            => $alumni->id,
                'batch_id'             => $this->batch_id,
                'is_batch_rep'         => $this->is_batch_rep,
                'did_graduate'         => $this->did_graduate,
                'school_year_attended' => $this->school_year_attended ?: null,
            ]);

            $user = User::create([
                'username'             => $username,
                'password'             => Hash::make($temporaryPassword),
                'alumni_id'            => $alumni->id,
                'must_change_password' => true,
                'email'                => $this->email,
            ]);

            $roleToAssign = $this->is_batch_rep ? 'batch-representative' : 'alumni';
            $user->syncRoles([$roleToAssign]);
        });

        $fullName = trim("{$this->fname} {$this->lname}");
        Mail::to($this->email)->send(new WelcomeCredentials($fullName, $username, $temporaryPassword));

        session()->flash('success', $this->is_batch_rep
            ? "Batch representative account created. Credentials sent to {$this->email}."
            : "Alumni account created. Credentials sent to {$this->email}."
        );

        $this->resetForm();
    }

    protected function generateAlumniUsername(): string
    {
        $base = strtolower(
            preg_replace('/[^a-z]/i', '', $this->lname)
            . substr($this->fname, 0, 1)
        );

        $year     = Batch::whereKey($this->batch_id)->value('yeargrad') ?? '0000';
        $username = "batch{$year}-{$base}";
        $original = $username;
        $i        = 1;

        while (User::where('username', $username)->exists()) {
            $username = $original . $i++;
        }

        return $username;
    }

    protected function generateStaffUsername(): string
    {
        $base     = 'staff-' . strtolower(preg_replace('/[^a-z]/i', '', $this->lname) . substr($this->fname, 0, 1));
        $username = $base;
        $i        = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . $i++;
        }

        return $username;
    }

    protected function generateTempPassword(int $length = 14): string
    {
        return collect(str_split('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%'))
            ->shuffle()
            ->take($length)
            ->implode('');
    }

    public function render()
    {
        return view('livewire.create-user', [
            'batches'    => $this->batches,
            'staffRoles' => self::STAFF_ROLES,
        ]);
    }
}
