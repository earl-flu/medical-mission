<?php

namespace App\Imports;

use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {
            return new Item([
                'name'     => $row['name'],
                'quantity'    => $row['quantity'],
                'restock_threshold' => $row['restock_threshold'],
            ]);
        });
    }
}
