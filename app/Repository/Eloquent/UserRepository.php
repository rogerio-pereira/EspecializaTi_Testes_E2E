<?php

namespace App\Repository\Eloquent;

use App\Models\User;

class UserRepository
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