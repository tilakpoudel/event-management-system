<?php

use App\Models\Event;
use Tests\TestCase;

class DebugTest extends TestCase
{
    public function test_events_index()
    {
        Event::factory(3)->create();
        
        $response = $this->get('/events');
        
        if ($response->status() === 500) {
            dd($response->exception);
        }
        
        $response->assertStatus(200);
    }
}
