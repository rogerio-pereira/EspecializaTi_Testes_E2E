<?php

namespace Tests\Feature\App\Repository\Eloquent;

use Tests\TestCase;
use App\Models\User;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repository\Interfaces\UserRepositoryInterface;

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
}
