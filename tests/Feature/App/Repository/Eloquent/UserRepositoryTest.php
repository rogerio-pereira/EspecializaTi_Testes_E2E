<?php

namespace Tests\Feature\App\Repository\Eloquent;

use Tests\TestCase;
use App\Models\User;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Database\QueryException;

class UserRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp() : void
    {
        $this->repository = new UserRepository(new User());

        parent::setUp();
    }

    public function testImplementsInterface()
    {
        $this->assertInstanceOf(
            UserRepositoryInterface::class, 
            $this->repository 
        );
    }

    public function testFindAllEmpty()
    {
        $users = $this->repository
                    ->findAll();

        $this->assertIsArray($users);
        $this->assertCount(0, $users);
    }
 
    public function testFindAll()
    {
        User::factory(10)->create();

        $users = $this->repository
                    ->findAll();

        $this->assertIsArray($users);
        $this->assertCount(10, $users);
    }

    public function testCreate()
    {
        $data = [
            'name' => 'Rogerio Pereira',
            'email' => 'test@test.com',
            'password' => bcrypt('test123'),
        ];

        $user = $this->repository->create($data);

        $this->assertNotNull($user);
        $this->assertIsObject($user);
        $this->assertDatabaseHas('users', $data);
    }

    public function testCreateException()
    {
        $this->expectException(QueryException::class);

        $data = [
            'name' => 'Rogerio Pereira',
            'password' => bcrypt('test123'),
        ];

        $user = $this->repository->create($data);
    }

    public function testUpdate()
    {
        $user = User::factory()->create(['email' => 'test@email.com']);
        $data = [
            'name' => 'Rogerio Pereira',
        ];

        $this->assertDatabaseMissing('users', [
            'email' => 'test@email.com',
            'name' => 'Rogerio Pereira',
        ]);
        $updatedUser = $this->repository->update($user->email, $data);

        $this->assertNotNull($updatedUser);
        $this->assertIsObject($updatedUser);
        $this->assertDatabaseHas('users', [
            'email' => 'test@email.com',
            'name' => 'Rogerio Pereira',
        ]);
    }
}
