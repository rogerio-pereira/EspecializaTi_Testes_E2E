<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertJson;

class UserApiTest extends TestCase
{
    protected string $url = '/api/users';

    public function testGetUsersEmpty()
    {
        $response = $this->getJson($this->url);

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data')
            ->assertJsonStructure([
                'data' => [],
                'meta' => [
                    'total',
                    'current_page',
                    'last_page',
                    'first_page',
                    'per_page',
                ]
            ])
            ->assertJsonFragment(['total' => 0]);
    }

    public function testGetUsers()
    {
        User::factory(5)->create();

        $response = $this->getJson($this->url);

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    public function testGetUsersPaginate()
    {
        User::factory(50)->create();

        $response = $this->getJson($this->url);

        $response->assertStatus(200)
            ->assertJsonCount(15, 'data')
            ->assertJsonStructure([
                'data' => [],
                'meta' => [
                    'total',
                    'current_page',
                    'last_page',
                    'first_page',
                    'per_page',
                ]
            ])
            ->assertJsonFragment(['total' => 50])
            ->assertJsonFragment(['current_page' => 1]);
    }

    public function testGetUsersPaginatePage2()
    {
        User::factory(20)->create();

        $response = $this->getJson($this->url.'?page=2');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonFragment(['total' => 20])
            ->assertJsonFragment(['current_page' => 2]);
    }
}
