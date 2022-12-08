<?php

namespace Tests\Feature\App\Repository\Eloquent;

use Tests\TestCase;
use App\Models\User;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Exception\NotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repository\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Database\QueryException;
use Throwable;

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

    public function testDelete()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'email' => $user->email, 
            'name' => $user->name
        ]);
        $deleted = $this->repository->delete($user->email);

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('users', [
            'email' => $user->email, 
            'name' => $user->name
        ]);
    }

    public function testDeleteException()
    {
        $this->assertDatabaseMissing('users', [
            'email' => 'test@test.com',
        ]);

        //another way to do it, i prefer uncommented way because is cleaner and readable
        /*try {
            $deleted = $this->repository->delete('test@test.com');

            $this->assertTrue(false); //If reached this point something is invalid, it should throw an exception
        } catch(Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }*/

        $this->expectException(NotFoundException::class);

        $deleted = $this->repository->delete('test@test.com');
    }

    public function testFind()
    {
        $user = User::factory()->create();

        $returnedUser = $this->repository->find($user->email);

        $this->assertIsObject($returnedUser);
    }

    public function testFindNotFound()
    {
        $returnedUser = $this->repository->find('test@test.com');

        $this->assertNull($returnedUser);
    }
}
