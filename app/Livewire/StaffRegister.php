<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register — Non-Alumni')]
#[Layout('components.layouts.full-page')]
class StaffRegister extends Component
{
    public function render()
    {
        return view('livewire.staff-register');
    }
}
