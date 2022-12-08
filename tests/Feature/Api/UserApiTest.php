<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    protected string $url = '/api/users';

    public function testGetUsersEmpty()
    {
        $response = $this->getJson($this->url);

        $response->assertStatus(200)
            ->assertJson([]);
    }
}
