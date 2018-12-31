<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PingTest extends TestCase
{
    /**
     * @test
     */
    public function get_ping()
    {
        $response = $this->get('/api/ping');

        $response->assertStatus(200);
        $response->assertExactJson(['message' => 'pong']);
    }

}
