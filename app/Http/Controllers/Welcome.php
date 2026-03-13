<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
class Welcome extends Controller
{
    public function index()
    {
        $event = Event::query()
            ->select('title', 'venue', 'event_date', 'description')
            ->whereNotNull('event_date')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->first();

        return view('welcome', [
            'event' => $event,
        ]);
    }
}
