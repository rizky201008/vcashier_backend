<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepositoryImpl implements CustomerRepository
{

    public function findAll(): array
    {
        return Customer::all()->toArray();
    }

    public function findById(int $id): Customer
    {
        return Customer::find($id);
    }

    public function create(Customer $customer): Customer
    {
        $customer->save();
        return $customer;
    }

    public function update(Customer $customer): Customer
    {
        $customer->save();
        return $customer;
    }
}
