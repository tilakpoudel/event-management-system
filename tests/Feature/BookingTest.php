<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that unauthenticated users cannot access bookings.
     */
    public function test_bookings_index_requires_authentication(): void
    {
        $response = $this->get('/bookings');

        $response->assertRedirect('/login');
    }

    /**
     * Test that authenticated user can see their bookings.
     */
    public function test_user_can_view_their_bookings(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        Booking::factory()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        $response = $this->actingAs($user)->get('/bookings');

        $response->assertStatus(200);
        $response->assertViewIs('bookings.index');
        $response->assertViewHas('bookings');
    }

    /**
     * Test that user can book an event.
     */
    public function test_user_can_book_event(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['capacity' => 10]);

        $response = $this->actingAs($user)
            ->post('/bookings', ['event_id' => $event->id]);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        $response->assertRedirect(route('events.show', $event));
    }

    /**
     * Test that user cannot book the same event twice.
     */
    public function test_user_cannot_book_same_event_twice(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        Booking::factory()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        $response = $this->actingAs($user)
            ->post('/bookings', ['event_id' => $event->id]);

        $response->assertSessionHas('error');
        $this->assertEquals(1, $event->bookings()->where('user_id', $user->id)->count());
    }

    /**
     * Test that user cannot book fully booked event.
     */
    public function test_user_cannot_book_fully_booked_event(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['capacity' => 1]);
        $other = User::factory()->create();
        Booking::factory()->create([
            'user_id' => $other->id,
            'event_id' => $event->id,
        ]);

        $response = $this->actingAs($user)
            ->post('/bookings', ['event_id' => $event->id]);

        $response->assertSessionHas('error', 'This event is fully booked.');
    }

    /**
     * Test that user can cancel their booking.
     */
    public function test_user_can_cancel_booking(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        $response = $this->actingAs($user)->delete("/bookings/{$booking->id}");

        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
        $response->assertSessionHas('success');
    }

    /**
     * Test that user cannot cancel other user's booking.
     */
    public function test_user_cannot_cancel_others_booking(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $event = Event::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $other->id,
            'event_id' => $event->id,
        ]);

        $response = $this->actingAs($user)->delete("/bookings/{$booking->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('bookings', ['id' => $booking->id]);
    }

    /**
     * Test that unauthenticated users cannot book events.
     */
    public function test_unauthenticated_user_cannot_book_event(): void
    {
        $event = Event::factory()->create();

        $response = $this->post('/bookings', ['event_id' => $event->id]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('bookings', ['event_id' => $event->id]);
    }
}
