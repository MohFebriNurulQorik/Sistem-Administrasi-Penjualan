<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Item([
            'code' => $row['code'],
            'name' => $row['name'],
            'uom' => $row['uom'] ?? null,
            'price' => $row['price'] ?? 0,
            'type' => $row['type'],
        ]);
    }
}