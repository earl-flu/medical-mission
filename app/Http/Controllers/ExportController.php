<?php

namespace App\Http\Controllers;

use App\Exports\DisposedItemsExport;
use App\Exports\InventoryExport;
use App\Exports\OrderItemsExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportOrderedItems(Request $request)
    {
        $date = $request->input('date');

        if (!$date) {
            // Return a forbidden response
            abort(403, 'Date is required.');
        }

        return Excel::download(new OrderItemsExport($date), "patientOrders-$date.xlsx");
    }

    public function exportDisposedItemsTotal(Request $request)
    {
        $date = $request->input('date');

        if (!$date) {
            // Return a forbidden response
            abort(403, 'Date is required.');
        }

        return Excel::download(new DisposedItemsExport($date), "totalPerDisposedItem-$date.xlsx");
    }

    public function exportInventory()
    {
        $currentDateTime = Carbon::now();
        return Excel::download(new InventoryExport, "inventory-$currentDateTime.xlsx");
    }
}
