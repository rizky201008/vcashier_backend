<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepositoryImpl;
use App\Services\CategoryService;
use App\Services\CategoryServiceImpl;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct()
    {
        $repository = new CategoryRepositoryImpl();
        $this->categoryService = new CategoryServiceImpl($repository);
    }

    public function getCategories()
    {
        return response()->json(
            [
                'message' => 'success',
                'status' => 200,
                'data' => $this->categoryService->getAllCategories(),
            ]
        );
    }

    public function getCategory($id)
    {
        return response()->json(
            [
                'message' => 'success',
                'status' => 200,
                'data' => $this->categoryService->getCategory($id),
            ]
        );
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return response()->json([
            'message' => 'success',
            'status' => 201,
            'data' => $this->categoryService->createCategory($request->all()),
        ], 201);
    }

    public function updateCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id' => 'required|integer|exists:categories,id',
        ]);

        return response()->json([
            'message' => 'success',
            'status' => 200,
            'data' => $this->categoryService->updateCategory($request->all()),
        ], 200);
    }
}
