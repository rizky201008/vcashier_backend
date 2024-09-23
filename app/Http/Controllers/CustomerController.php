<?php

namespace App\Http\Controllers;

use App\Repositories\CustomerRepositoryImpl;
use App\Services\CustomerService;
use App\Services\CustomerServiceImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    private CustomerService $customerService;

    public function __construct()
    {
        $customerRepository = new CustomerRepositoryImpl();
        $this->customerService = new CustomerServiceImpl($customerRepository);
    }

    public function getCustomers(): JsonResponse
    {
        return response()->json([
            "message" => "success",
            "status" => 200,
            "data" => $this->customerService->getCustomers()
        ], 200);
    }

    public function getCustomer($id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:customers,id'
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first(), 400);
        }

        return response()->json([
            "message" => "success",
            "status" => 200,
            "data" => $this->customerService->getCustomer($id)
        ], 200);
    }

    public function createCustomer(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|integer'
        ]);
        return response()->json([
            "message" => "success",
            "status" => 200,
            "data" => $this->customerService->createCustomer($request->all())
        ], 200);
    }

    public function updateCustomer(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|integer|exists:customers,id',
            'name' => 'string|max:255',
            'phone_number' => 'integer'
        ]);

        return response()->json([
            "message" => "success",
            "status" => 200,
            "data" => $this->customerService->updateCustomer($request->all())
        ], 200);
    }
}
