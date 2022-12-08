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

    public function dataProviderPagination() : array
    {
        return [
            'paginate empty'    =>  ['total' => 0, 'page' => 1, 'itemsInPage' => 0],
            'total 15 page 1'   =>  ['total' => 15, 'page' => 1, 'itemsInPage' => 15],
            'total 40 page 1'   =>  ['total' => 40, 'page' => 1, 'itemsInPage' => 15],
            'total 40 page 3'   =>  ['total' => 40, 'page' => 3, 'itemsInPage' => 10],
            'total 20 page 2'   =>  ['total' => 20, 'page' => 2, 'itemsInPage' => 5],
            'total 100 page 2'  =>  ['total' => 100, 'page' => 2, 'itemsInPage' => 15],
        ];
    }

    /**
     * @dataProvider dataProviderPagination
     */
    public function testGetUsersPaginate(
        int $total,
        int $page = 1,
        int $itemsInPage = 15
    ) {
        User::factory($total)->create();

        $response = $this->getJson("{$this->url}?page={$page}");

        $response->assertStatus(200)
            ->assertJsonCount($itemsInPage, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ]
                ],
                'meta' => [
                    'total',
                    'current_page',
                    'last_page',
                    'first_page',
                    'per_page',
                ]
            ])
            ->assertJsonFragment(['total' => $total])
            ->assertJsonFragment(['current_page' => $page]);
    }

    public function testCreateUser()
    {
        $data = [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'password' => 'abc123',
        ];
        $this->assertDatabaseMissing('users', [
            'name' => 'Test Name',
            'email' => 'test@email.com',
        ]);

        $response = $this->postJson($this->url, $data);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test Name',
            'email' => 'test@email.com',
        ]);
    }

    public function testCreateUserValidations()
    {
        $data = [
            'email' => 'test@email.com',
            'password' => 'abc123',
        ];

        $response = $this->postJson($this->url, $data);
        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [
                    'name',
                ]
            ]);
    }
}
