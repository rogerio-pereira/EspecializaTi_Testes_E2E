<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Interfaces\UserRepositoryInterface;

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

    public function create(array $data) : object
    {
        return $this->model
                    ->create($data);
    }

    public function update(string $email, array $data) : object
    {
        $user = $this->model
                    ->where('email', $email)
                    ->first();

        $user->update($data);

        return $user;
    }
}