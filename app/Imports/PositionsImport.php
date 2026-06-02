<?php

namespace App\Imports;

use App\Models\Position;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PositionsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Position([
            'position_name' => $row['position_name'] ?? null,
        ]);
    }
}
