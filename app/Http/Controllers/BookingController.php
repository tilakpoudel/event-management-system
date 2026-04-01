<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's bookings.
     */
    public function index(): View
    {
        $bookings = auth()->user()
            ->bookings()
            ->with('event')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Store a newly created booking in the database.
     */
    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $event = Event::findOrFail($request->event_id);

        // Check if user already booked this event
        if ($event->bookings()->where('user_id', auth()->id())->exists()) {
            return redirect()
                ->back()
                ->with('error', 'You have already booked this event.');
        }

        // Check if event has available seats
        $bookedCount = $event->bookings()->count();
        if ($bookedCount >= $event->capacity) {
            return redirect()
                ->back()
                ->with('error', 'This event is fully booked.');
        }

        auth()->user()->bookings()->create([
            'event_id' => $event->id,
        ]);

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'You have successfully booked this event.');
    }

    /**
     * Remove the specified booking from the database.
     */
    public function destroy(Booking $booking): RedirectResponse
    {
        $this->authorize('delete', $booking);

        $event = $booking->event;
        $booking->delete();

        return redirect()
            ->back()
            ->with('success', 'Booking cancelled successfully.');
    }
}
