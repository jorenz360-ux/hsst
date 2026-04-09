<?php

namespace App\Livewire;

use App\Models\Alumni;
use App\Models\AlumniEducation;
use App\Models\Batch;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Add User')]
class CreateUser extends Component
{
    public string $generatedUsername = '';
    public string $generatedPassword = '';
    public bool $showCredentials = false;

    // Alumni fields
    public string $lname = '';
    public string $fname = '';
    public string $mname = '';

    // Education fields
    public ?int $batch_id = null;
    public bool $is_batch_rep = false;
    public bool $did_graduate = true;
    public string $school_year_attended = '';

    public function getBatchesProperty()
    {
        return Batch::query()->orderBy('level')->orderByDesc('yeargrad')->get();
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

    public function resetForm(): void
    {
        $this->reset([
            'lname', 'fname', 'mname',
            'batch_id', 'is_batch_rep', 'did_graduate', 'school_year_attended',
            'showCredentials', 'generatedUsername', 'generatedPassword',
        ]);
    }

    public function save(): void
    {
        $this->validate([
            'lname'                => 'required|string|max:80',
            'fname'                => 'required|string|max:80',
            'mname'                => 'nullable|string|max:80',
            'batch_id'             => 'required|exists:batches,id',
            'is_batch_rep'         => 'boolean',
            'did_graduate'         => 'boolean',
            'school_year_attended' => 'nullable|string|max:50',
        ]);

        $this->generatedUsername = $this->generateUsername();
        $this->generatedPassword = $this->generateTempPassword();

        DB::transaction(function () {
            // If marking as batch rep, demote any existing rep for this batch
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
                'username'             => $this->generatedUsername,
                'password'             => Hash::make($this->generatedPassword),
                'alumni_id'            => $alumni->id,
                'must_change_password' => true,
                'email'                => null,
            ]);

            $roleToAssign = $this->is_batch_rep ? 'batch-representative' : 'alumni';
            $user->syncRoles([$roleToAssign]);
        });

        $this->showCredentials = true;
        session()->flash('success', $this->is_batch_rep
            ? 'Batch representative account created successfully.'
            : 'Alumni account created successfully.'
        );
    }

    protected function generateUsername(): string
    {
        $base = strtolower(
            preg_replace('/[^a-z]/i', '', $this->lname)
            . substr($this->fname, 0, 1)
        );

        $year = Batch::whereKey($this->batch_id)->value('yeargrad') ?? '0000';

        $username = "batch{$year}-{$base}";
        $original = $username;
        $i = 1;

        while (User::where('username', $username)->exists()) {
            $username = $original . $i++;
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
            'batches' => $this->batches,
        ]);
    }
}
