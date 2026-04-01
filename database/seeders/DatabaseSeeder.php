<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Booking;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users
        $users = User::factory(5)->create();

        // Create a test user with known credentials
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create events with their creators from the users
        $events = [];
        foreach ($users as $user) {
            $userEvents = Event::factory(3)->create([
                'user_id' => $user->id,
            ]);
            $events = array_merge($events, $userEvents->toArray());
        }

        // Create bookings - ensure no duplicate bookings for the same event by the same user
        foreach ($users as $user) {
            $eventsToBook = Event::where('user_id', '!=', $user->id)
                ->inRandomOrder()
                ->limit(rand(1, 3))
                ->get();

            foreach ($eventsToBook as $event) {
                // Check if user already booked this event
                if (!Booking::where('user_id', $user->id)
                    ->where('event_id', $event->id)
                    ->exists()) {
                    Booking::factory()->create([
                        'user_id' => $user->id,
                        'event_id' => $event->id,
                    ]);
                }
            }
        }
    }
}

