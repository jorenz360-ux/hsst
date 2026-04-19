<?php

namespace App\Livewire;

use App\Mail\StaffRegistrationPending;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register — Non-Alumni')]
#[Layout('components.layouts.auth')]
class StaffRegister extends Component
{
    public string $fname = '';
    public string $lname = '';
    public string $mname = '';
    public string $address_line_1 = '';
    public string $address_line_2 = '';
    public string $city = '';
    public string $state_province = '';
    public string $postal_code = '';
    public string $country = 'Philippines';
    public int|string $years_working = '';
    public string $account_type = '';
    public string $position = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function save(): void
    {
        $this->validate([
            'fname'               => 'required|string|max:80',
            'lname'               => 'required|string|max:80',
            'mname'               => 'nullable|string|max:80',
            'address_line_1'      => 'required|string|max:255',
            'address_line_2'      => 'nullable|string|max:255',
            'city'                => 'required|string|max:100',
            'state_province'      => 'required|string|max:100',
            'postal_code'         => 'required|string|max:20',
            'country'             => 'required|string|max:100',
            'years_working'       => 'required|integer|min:1|max:99',
            'position'            => 'required|string|max:100',
            'account_type'        => 'required|in:staff,employee,ssps-member',
            'email'               => 'required|email|max:255|unique:users,email',
            'password'            => 'required|string|min:8|confirmed',
        ]);

        $staff = null;

        DB::transaction(function () use (&$staff) {
            $staff = Staff::create([
                'fname'          => $this->fname,
                'lname'          => $this->lname,
                'mname'          => $this->mname ?: null,
                'address_line_1' => $this->address_line_1,
                'address_line_2' => $this->address_line_2 ?: null,
                'city'           => $this->city,
                'state_province' => $this->state_province,
                'postal_code'    => $this->postal_code,
                'country'        => $this->country,
                'years_working'  => (int) $this->years_working,
                'position'       => $this->position,
            ]);

            $user = User::create([
                'username'  => $this->generateUsername(),
                'email'     => $this->email,
                'password'  => Hash::make($this->password),
                'staff_id'  => $staff->id,
                'is_active' => false,
            ]);

            $user->assignRole($this->account_type);
        });

        User::role('reunion-coordinator')
            ->whereNotNull('email')
            ->get()
            ->each(fn ($coordinator) =>
                Mail::to($coordinator->email)->send(new StaffRegistrationPending($staff, $this->account_type))
            );

        $this->redirect(route('staff.pending'), navigate: true);
    }

    protected function generateUsername(): string
    {
        $base = 'staff-' . strtolower(preg_replace('/[^a-z]/i', '', $this->lname)) . strtolower(substr($this->fname, 0, 1));
        $username = $base;
        $i = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . $i++;
        }

        return $username;
    }

    public function render()
    {
        return view('livewire.staff-register');
    }
}
