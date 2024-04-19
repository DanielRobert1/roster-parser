<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\RosterEvent;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FetchRosterTest extends TestCase
{
    /**
     * Test can fetch a roster
     */
    public function test_can_fetch_roster(): void
    {
        $roster = RosterEvent::factory()->create();

        $response = $this->getJson(route('api.roster'), []);

        $response->assertStatus(200)
                 ->assertJsonStructure(['status', 'data']);

    }
}
