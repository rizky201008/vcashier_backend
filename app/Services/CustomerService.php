<?php

namespace App\Services;

use App\Models\Customer;

interface CustomerService
{
    public function getCustomers(): array;

    public function getCustomer(int $id): object;

    public function createCustomer(array $data): object;

    public function updateCustomer(array $data): object;

}
