<?php

namespace App\Services;

use App\Models\Category;
use App\Models\User;
use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryServiceImpl implements CategoryService
{

    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(): array
    {
        DB::beginTransaction();

        try {
            $categories = $this->categoryRepository->FindAll();
            DB::commit();
            return $categories;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function getCategory($id): object
    {
        DB::beginTransaction();

        try {
            $category = $this->categoryRepository->Find($id);
            DB::commit();
            return $category;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function createCategory(array $data): object
    {
        DB::beginTransaction();

        try {
            $category = new Category();
            $category->name = $data['name'];
            $result = $this->categoryRepository->Create($category);
            $category->id = $result->id;
            DB::commit();
            return $category;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function updateCategory(array $data): object
    {
        DB::beginTransaction();

        try {
            $category = $this->categoryRepository->Find($data['id']);
            $category->name = $data['name'];
            $result = $this->categoryRepository->Update($category);
            DB::commit();
            return [$result];
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage(), 500);
        }
    }
}
