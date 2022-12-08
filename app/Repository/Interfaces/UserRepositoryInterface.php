<?php

namespace App\Repository\Interfaces;

use stdClass;

interface UserRepositoryInterface
{
   public function findAll() : array;

   public function find(string $email) : ?object;  //return is the same as object|null 

   public function create(array $data) : object;

   public function update(string $email, array $data) : object;

   public function delete(string $email) : bool;
}
