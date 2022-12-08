<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Exception\NotFoundException;
use App\Repository\Interfaces\PaginatedResponseInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Repository\Presenters\PaginationPresenter;
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

    public function paginate(int $page = 1) : PaginatedResponseInterface
    {
        $users = $this->model
                    ->paginate();

        return new PaginationPresenter($users);
    }

    public function find(string $email) : object
    {
        $user = $this->model
                    ->where('email', $email)
                    ->first();

        if(!$user)
            throw new NotFoundException('User not found');

        return $user;
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
        return $this->find($email)
                    ->delete();
    }
}