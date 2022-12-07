<?php

namespace Core\Category;

class CreateCategoryUseCase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository) 
    {
        $this->repository = $repository;
    }
}