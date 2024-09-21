<?php

namespace App\Repositories;

use App\Models\Category;

interface CategoryRepository
{
    public function Create(Category $category) : Category;
    public function Update(Category $category) : Category;
    public function Find($id) : Category;
    public function FindAll() : array;
}
