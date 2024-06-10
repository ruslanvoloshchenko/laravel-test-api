<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Submission;

class SubmitEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the /submit endpoint with valid data.
     *
     * @return void
     */
    public function test_valid_submission()
    {
        // Prepare the payload
        $payload = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.'
        ];

        // Send a POST request to the /submit endpoint
        $response = $this->postJson('/api/submit', $payload);

        // Assert the response status
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Data received and is being processed'
            ]);

        // Assert the data is in the database
        $this->assertDatabaseHas('submissions', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.'
        ]);
    }

    /**
     * Test the /submit endpoint with invalid data.
     *
     * @return void
     */
    public function test_invalid_submission()
    {
        // Prepare the payload with missing fields
        $payload = [
            'name' => '',
            'email' => 'not-an-email',
            'message' => ''
        ];

        // Send a POST request to the /submit endpoint
        $response = $this->postJson('/api/submit', $payload);

        // Assert the response status
        $response->assertStatus(400)
            ->assertJsonStructure([
                'status',
                'message'
            ]);
    }
}
