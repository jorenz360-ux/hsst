<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));
        $selectedDate = $request->query('date', now()->toDateString());

        $calendarStart = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $calendarEnd = $calendarStart->copy()->endOfMonth();

        $events = Event::query()
            ->select([
                'id',
                'title',
                'venue',
                'event_date',
                'description',
                'dress_code',
            ])
            ->with([
                'schedules' => fn ($query) => $query
                    ->select([
                        'id',
                        'event_id',
                        'title',
                        'description',
                        'schedule_time',
                        'sort_order',
                    ])
                    ->orderBy('sort_order')
                    ->orderBy('schedule_time'),
            ])
            ->whereNotNull('event_date')
            ->whereDate('event_date', '>=', today())
            ->orderBy('event_date', 'asc')
            ->paginate(9)
            ->withQueryString();

        $featuredEvent = Event::query()
            ->select([
                'id',
                'title',
                'venue',
                'event_date',
                'description',
                'dress_code',
            ])
            ->with([
                'schedules' => fn ($query) => $query
                    ->select([
                        'id',
                        'event_id',
                        'title',
                        'description',
                        'schedule_time',
                        'sort_order',
                    ])
                    ->orderBy('sort_order')
                    ->orderBy('schedule_time'),
            ])
            ->whereNotNull('event_date')
            ->whereDate('event_date', '>=', today())
            ->orderBy('event_date', 'asc')
            ->first();

        $calendarEvents = Event::query()
            ->select([
                'id',
                'title',
                'venue',
                'event_date',
                'description',
            ])
            ->with([
                'schedules' => fn ($query) => $query
                    ->select([
                        'id',
                        'event_id',
                        'title',
                        'description',
                        'schedule_time',
                        'sort_order',
                    ])
                    ->orderBy('sort_order')
                    ->orderBy('schedule_time'),
            ])
            ->whereNotNull('event_date')
            ->whereBetween('event_date', [
                $calendarStart->copy()->startOfMonth(),
                $calendarEnd->copy()->endOfMonth(),
            ])
            ->orderBy('event_date', 'asc')
            ->get();

        $eventsByDate = $calendarEvents
            ->groupBy(fn ($event) => Carbon::parse($event->event_date)->toDateString());

        $gridStart = $calendarStart->copy()->startOfWeek(Carbon::SUNDAY);
        $gridEnd = $calendarEnd->copy()->endOfWeek(Carbon::SATURDAY);

        $calendarDays = collect();
        $cursor = $gridStart->copy();

        while ($cursor <= $gridEnd) {
            $dateKey = $cursor->toDateString();
            $dayEvents = $eventsByDate->get($dateKey, collect());

            $calendarDays->push([
                'date' => $dateKey,
                'day' => $cursor->day,
                'isCurrentMonth' => $cursor->month === $calendarStart->month,
                'isToday' => $cursor->isToday(),
                'isSelected' => $selectedDate === $dateKey,
                'events' => $dayEvents,
                'count' => $dayEvents->count(),
            ]);

            $cursor->addDay();
        }

        $selectedDayEvents = $eventsByDate->get($selectedDate, collect());

        return view('public.index', [
            'events' => $events,
            'featuredEvent' => $featuredEvent,
            'calendarDays' => $calendarDays,
            'selectedDayEvents' => $selectedDayEvents,
            'calendarLabel' => $calendarStart->format('F Y'),
            'selectedDateLabel' => Carbon::parse($selectedDate)->format('F d, Y'),
            'prevMonth' => $calendarStart->copy()->subMonth()->format('Y-m'),
            'nextMonth' => $calendarStart->copy()->addMonth()->format('Y-m'),
            'currentMonth' => $month,
            'selectedDate' => $selectedDate,
        ]);
    }

    public function show(Event $event)
    {
        $event->load([
            'schedules' => fn ($query) => $query
                ->select([
                    'id',
                    'event_id',
                    'title',
                    'description',
                    'schedule_time',
                    'sort_order',
                ])
                ->orderBy('sort_order')
                ->orderBy('schedule_time'),
        ]);

        return view('public.show', [
            'event' => $event,
        ]);
    }
}