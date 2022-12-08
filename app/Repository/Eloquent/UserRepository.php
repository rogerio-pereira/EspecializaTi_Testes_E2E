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
}