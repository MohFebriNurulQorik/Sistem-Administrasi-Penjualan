<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Customer([
            'company_name' => $row['company_name'],
            'email' => $row['email'] ?? null,
            'phone' => $row['phone'] ?? null,
            'address' => $row['address'] ?? null,
            'attn' => $row['attn'] ?? null,
            'job' => $row['job'] ?? null,
        ]);
    }
}