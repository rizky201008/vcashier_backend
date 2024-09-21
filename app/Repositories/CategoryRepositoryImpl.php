<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepositoryImpl implements CategoryRepository
{

    public function Create(Category $category): Category
    {
        $category->save();
        return $category;
    }

    public function Update(Category $category): Category
    {
        Category::find($category->id)->update($category);
        return $category;
    }

    public function Find($id): Category
    {
        return Category::find($id);
    }

    public function FindAll(): array
    {
        return Category::all()->toArray();
    }
}
