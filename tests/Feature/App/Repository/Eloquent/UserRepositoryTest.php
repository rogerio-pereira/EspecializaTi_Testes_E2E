<?php

namespace Tests\Feature\App\Repository\Eloquent;

use Tests\TestCase;
use App\Models\User;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRepositoryTest extends TestCase
{
    public function testFindAllEmpty()
    {
        $repository = new UserRepository(new User());
        $users = $repository->findAll();

        $this->assertIsArray($users);
        $this->assertCount(0, $users);
    }
 
    public function testFindAll()
    {
        User::factory(10)->create();

        $repository = new UserRepository(new User());
        $users = $repository->findAll();

        $this->assertIsArray($users);
        $this->assertCount(10, $users);
    }
}
