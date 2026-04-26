<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('home');
        }

        if ($user->hasRole('cashier')) {
            return redirect()->route('donations');
        }

        return redirect()->route('dashboard');
    }
}
