<?php

namespace App\Repositories;

use App\Models\Customer;

interface CustomerRepository
{
    public function findAll(): array;

    public function findById(int $id): Customer;

    public function create(Customer $customer): Customer;

    public function update(Customer $customer): Customer;
}
