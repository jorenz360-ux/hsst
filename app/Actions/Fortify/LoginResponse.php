<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
       return $request->user()
        ? redirect()->route('dashboard')
        : redirect()->route('home');
    }
}
