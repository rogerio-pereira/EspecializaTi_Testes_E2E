<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Exception\NotFoundException;
use App\Repository\Interfaces\UserRepositoryInterface;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected User $model
    ) { }

    public function findAll() : array
    {
        return $this->model
                    ->get()
                    ->toArray();
    }

    public function find(string $email) : ?object
    {
        return $this->model
                    ->where('email', $email)
                    ->first();
    }

    public function create(array $data) : object
    {
        return $this->model
                    ->create($data);
    }

    public function update(string $email, array $data) : object
    {
        $user = $this->find($email);

        $user->update($data);

        return $user;
    }

    public function delete(string $email) : bool
    {
        $user = $this->find($email);

        if(!$user) {
            throw new NotFoundException("User not found");
        }

        return $user->delete();
    }
}