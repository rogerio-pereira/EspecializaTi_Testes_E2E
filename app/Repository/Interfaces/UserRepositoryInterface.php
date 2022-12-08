<?php

namespace App\Repository\Interfaces;

use stdClass;

interface UserRepositoryInterface
{
   public function findAll() : array;

   public function create(array $data) : object;

   public function update(string $id, array $data) : object;
}
