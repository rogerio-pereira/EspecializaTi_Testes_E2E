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

    /*
     * PROVIDERS
     */
    #region providers
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

    public function dataProviderCreateUser() : array
    {
        return [
            'ok' => [
                    'payload' => [
                        'name' => 'Test Name',
                        'email' => 'email@email.com',
                        'password' => 'abc123',
                    ],
                    'statusCode' => 201,
                    'responseStructure' => [
                        'data' => [
                            'id',
                            'name',
                            'email',
                        ]
                    ]
                ],
            'validation_required' => [
                    'payload' => [],
                    'statusCode' => 422,
                    'responseStructure' => [
                        'errors' => [
                            'name',
                            'email',
                            'password',
                        ]
                    ]
                ],
            'validation_min' => [
                    'payload' => [
                        'name' => 'a',
                        'password' => 'a',
                    ],
                    'statusCode' => 422,
                    'responseStructure' => [
                        'errors' => [
                            'name',
                            'password',
                        ]
                    ]
                ],
            'validation_max' => [
                    'payload' => [
                        'name' => str_pad('a', 256),
                        'email' => str_pad('a', 256),
                        'password' => str_pad('a', 16),
                    ],
                    'statusCode' => 422,
                    'responseStructure' => [
                        'errors' => [
                            'name',
                            'email',
                            'password',
                        ]
                    ]
                ],
            'validation_email' => [
                    'payload' => [
                        'email' => str_pad('aaa', 256),
                    ],
                    'statusCode' => 422,
                    'responseStructure' => [
                        'errors' => [
                            'email',
                        ]
                    ]
                ],
        ];
    }
    #endregion providers

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

    /**
     * @dataProvider dataProviderCreateUser
     */
    public function testCreateUser(
        array $payload,
        int $statusCode,
        array $responseStructure,
    ) {
        $response = $this->postJson($this->url, $payload);
        $response->assertStatus($statusCode)
            ->assertJsonStructure($responseStructure);
    }

    public function testFind(

    ) {
        $user = User::factory()->create();

        $response = $this->getJson($this->url."/{$user->email}");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                ]
            ]);
    }
}
