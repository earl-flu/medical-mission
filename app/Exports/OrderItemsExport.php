<?php

namespace App\Exports;

use App\Models\OrderItem;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderItemsExport implements FromCollection, WithHeadings
{

    private $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        return OrderItem::whereDate('created_at', $this->date)->get()->map(function ($orderItem) {
            return [
                $orderItem->id,
                $orderItem->patient->full_name,
                $orderItem->patient->municipality_str,
                $orderItem->patient->barangay_str,
                $orderItem->item->name,
                $orderItem->quantity,
                $orderItem->instruction,
                Carbon::parse($orderItem->created_at)->format('Y-m-d H:i:s'), // Format the created_at column
            ];
        });
    }

    public function headings(): array
    {
        // Define your heading row here
        return [
            ['CIA Medical Mission'],
            ["Disposed Item Date: $this->date"],
            ['Date Generated: ' . Carbon::now()->format('Y-m-d H:i:s')],
            ['This is a computer generated report [Disposed items per patient]'],
            [''],
            [
                'Order Item ID',
                'Patient Name',
                'Municipality',
                'Barangay',
                'Item Name',
                'Quantity',
                'Instructions',
                'Date Given',
            ]
        ];
    }
}
