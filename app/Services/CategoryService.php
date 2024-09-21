<?php

namespace App\Services;

interface CategoryService
{
    public function getAllCategories(): array;

    public function getCategory($id): object;

    public function createCategory(array $data): object;

    public function updateCategory(array $data): object;
}
