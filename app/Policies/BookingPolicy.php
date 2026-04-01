<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Determine whether the user can view their bookings.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the booking.
     */
    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }

    /**
     * Determine whether the user can create bookings.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the booking.
     */
    public function delete(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }

    /**
     * Determine whether the user can restore the booking.
     */
    public function restore(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }

    /**
     * Determine whether the user can permanently delete the booking.
     */
    public function forceDelete(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }
}
