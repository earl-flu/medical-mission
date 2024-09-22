<?php

namespace App\Exports;

use App\Models\Item;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Item::all()->map(function ($item) {
            return [
                $item->name,
                $item->quantity,
                $item->restock_threshold,
                'low_stock' => $item->quantity <= $item->restock_threshold ? 'low stock' : ''
            ];
        });
    }

    public function headings(): array
    {
        // Define your heading row here
        return [
            ['CIA Medical Mission'],
            ['Inventory Report: ' . Carbon::now()->format('Y-m-d H:i:s')],
            ['This is a computer generated report [Inventory]'],
            [''],
            [
                'Item Name',
                'Quantity',
                'Restock Threshold',
                'Stock Status',
            ]
        ];
    }
}
