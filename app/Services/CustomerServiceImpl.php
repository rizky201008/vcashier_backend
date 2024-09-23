<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class CustomerServiceImpl implements CustomerService
{

    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getCustomers(): array
    {
        return $this->customerRepository->findAll();
    }

    public function getCustomer(int $id): object
    {
        return $this->customerRepository->findById($id);
    }

    public function createCustomer(array $data): object
    {
        DB::beginTransaction();
        try {
            $customer = new Customer();
            $customer->name = $data['name'];
            $customer->phone_number = $data['phone_number'];
            $savedCustomer = $this->customerRepository->create($customer);
            DB::commit();
            return $savedCustomer;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function updateCustomer(array $data): object
    {
        DB::beginTransaction();

        try {
            $customer = new Customer();
            $customer->id = $data['id'];
            $customer->name = $data['name'];
            $customer->phone_number = $data['phone_number'];
            $updatedCustomer = $this->customerRepository->update($customer);
            DB::commit();
            return $updatedCustomer;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage(), 500);
        }
    }
}
