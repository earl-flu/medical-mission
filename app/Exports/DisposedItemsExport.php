<?php

namespace App\Exports;

use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DisposedItemsExport implements FromCollection, WithHeadings
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
        $disposedItems = OrderItem::select('items.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->join('items', 'items.id', '=', 'order_items.item_id')
            ->whereDate('order_items.created_at', $this->date)
            ->groupBy('item_id', 'items.name')
            ->get();

        return $disposedItems;
    }

    public function headings(): array
    {
        // Define your heading row here
        return [
            ['CIA Medical Mission'],
            ["Disposed Date: $this->date"],
            ['Date Generated: ' . Carbon::now()->format('Y-m-d H:i:s')],
            ['This is a computer generated report: [Total Items Disposed]'],
            [''],
            [
                'Item Name',
                'Total Disposed',
            ]
        ];
    }
}
