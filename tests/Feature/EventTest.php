<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that anyone can view the events index.
     */
    public function test_events_index_is_accessible(): void
    {
        Event::factory(3)->create();

        $response = $this->get('/events');

        $response->assertStatus(200);
        $response->assertViewIs('events.index');
        $response->assertViewHas('events');
    }

    /**
     * Test that unauthenticated users cannot view create form.
     */
    public function test_create_event_requires_authentication(): void
    {
        $response = $this->get('/events/create');

        $response->assertRedirect('/login');
    }

    /**
     * Test that authenticated users can see create form.
     */
    public function test_authenticated_user_can_see_create_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/events/create');

        $response->assertStatus(200);
        $response->assertViewIs('events.create');
    }

    /**
     * Test that authenticated user can create an event.
     */
    public function test_user_can_create_event(): void
    {
        $user = User::factory()->create();

        $eventData = [
            'title' => 'Test Event',
            'description' => 'Test Description',
            'date' => now()->addMonth()->format('Y-m-d'),
            'capacity' => 50,
        ];

        $response = $this->actingAs($user)
            ->post('/events', $eventData);

        $this->assertDatabaseHas('events', [
            'title' => 'Test Event',
            'user_id' => $user->id,
        ]);

        $event = Event::where('title', 'Test Event')->first();
        $response->assertRedirect(route('events.show', $event));
    }

    /**
     * Test that event creation fails with invalid data.
     */
    public function test_event_creation_fails_with_invalid_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/events', [
                'title' => '', // Missing title
                'date' => now()->subDay()->format('Y-m-d'), // Past date
                'capacity' => 0, // Invalid capacity
            ]);

        $response->assertSessionHasErrors(['title', 'date', 'capacity']);
    }

    /**
     * Test that anyone can view an event.
     */
    public function test_can_view_event(): void
    {
        $event = Event::factory()->create();

        $response = $this->get("/events/{$event->id}");

        $response->assertStatus(200);
        $response->assertViewIs('events.show');
        $response->assertViewHas('event', $event);
    }

    /**
     * Test that only event creator can edit.
     */
    public function test_only_creator_can_edit_event(): void
    {
        $creator = User::factory()->create();
        $other = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $creator->id]);

        $response = $this->actingAs($other)->get("/events/{$event->id}/edit");

        $response->assertStatus(403);
    }

    /**
     * Test that event creator can edit event.
     */
    public function test_creator_can_edit_event(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/events/{$event->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('events.edit');
    }

    /**
     * Test that event creator can update event.
     */
    public function test_creator_can_update_event(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->put("/events/{$event->id}", [
                'title' => 'Updated Title',
                'description' => 'Updated Description',
                'date' => now()->addMonth()->format('Y-m-d'),
                'capacity' => 100,
            ]);

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Updated Title',
        ]);

        $response->assertRedirect(route('events.show', $event));
    }

    /**
     * Test that only creator can delete event.
     */
    public function test_only_creator_can_delete_event(): void
    {
        $creator = User::factory()->create();
        $other = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $creator->id]);

        $response = $this->actingAs($other)->delete("/events/{$event->id}");

        $response->assertStatus(403);
    }

    /**
     * Test that event creator can delete event.
     */
    public function test_creator_can_delete_event(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/events/{$event->id}");

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
        $response->assertRedirect(route('events.index'));
    }
}
