<?php

namespace App\Http\Controllers;

use App\Mail\StaffRegistrationPending;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class StaffRegisterController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'fname'            => 'required|string|max:80',
            'lname'            => 'required|string|max:80',
            'mname'            => 'nullable|string|max:80',
            'address_line_1'   => 'required|string|max:255',
            'address_line_2'   => 'nullable|string|max:255',
            'city'             => 'required|string|max:100',
            'state_province'   => 'required|string|max:100',
            'postal_code'      => 'required|string|max:20',
            'country'          => 'required|string|max:100',
            'years_working'    => 'required|integer|min:1|max:99',
            'position'         => 'required|string|max:100',
            'account_type'     => 'required|in:staff,employee,ssps-member',
            'email'            => 'required|email|max:255|unique:users,email',
            'password'         => ['required', 'confirmed', Password::default()],
        ]);

        $staff = null;

        DB::transaction(function () use ($validated, &$staff) {
            $staff = Staff::create([
                'fname'          => $validated['fname'],
                'lname'          => $validated['lname'],
                'mname'          => $validated['mname'] ?: null,
                'address_line_1' => $validated['address_line_1'],
                'address_line_2' => $validated['address_line_2'] ?: null,
                'city'           => $validated['city'],
                'state_province' => $validated['state_province'],
                'postal_code'    => $validated['postal_code'],
                'country'        => $validated['country'],
                'years_working'  => (int) $validated['years_working'],
                'position'       => $validated['position'],
            ]);

            $user = User::create([
                'username' => $this->generateUsername($validated['fname'], $validated['lname']),
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'staff_id' => $staff->id,
                'is_active' => false,
            ]);

            $user->assignRole($validated['account_type']);
        });

        User::role('reunion-coordinator')
            ->where('is_active', true)
            ->whereNotNull('email')
            ->get()
            ->each(fn ($coordinator) => Mail::to($coordinator->email)->queue(new StaffRegistrationPending($staff, $validated['account_type'])));

        return redirect()->route('staff.pending');
    }

    protected function generateUsername(string $fname, string $lname): string
    {
        $base = 'staff-' . strtolower(preg_replace('/[^a-z]/i', '', $lname)) . strtolower(substr($fname, 0, 1));
        $username = $base;
        $i = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . $i++;
        }

        return $username;
    }
}
