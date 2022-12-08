<?php

namespace App\Repository\Interfaces;

use stdClass;

interface UserRepositoryInterface
{
   public function findAll() : array;

   public function create(array $data) : object;

   public function update(string $email, array $data) : object;

   public function delete(string $email) : bool;
}
