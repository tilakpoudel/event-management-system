<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of all events.
     */
    public function index(): View
    {
        $events = Event::with('user')
            ->orderBy('date', 'asc')
            ->paginate(10);

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        return view('events.create');
    }

    /**
     * Store a newly created event in the database.
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $event = $request->user()->events()->create($request->validated());

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified event with booking information.
     */
    public function show(Event $event): View
    {
        $event->load('bookings.user');
        $bookedCount = $event->bookings()->count();
        $availableSeats = $event->capacity - $bookedCount;
        $isUserBooked = auth()->check() && $event->bookings()
            ->where('user_id', auth()->id())
            ->exists();

        return view('events.show', compact('event', 'bookedCount', 'availableSeats', 'isUserBooked'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event): View
    {
        $this->authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified event in the database.
     */
    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $event->update($request->validated());

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event from the database.
     */
    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);
        
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
