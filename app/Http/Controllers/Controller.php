<?php

namespace App\Http\Controllers;

abstract class Controller
{
      public function render()
    {
        return view('public/about-us');
    }
}
