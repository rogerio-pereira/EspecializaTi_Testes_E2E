<?php

namespace Core\Category;

interface CategoryRepositoryInterface
{
    public function getAll() : array;
    public function create(array $data) : object;
    public function findById(string $id) : ?object;
}