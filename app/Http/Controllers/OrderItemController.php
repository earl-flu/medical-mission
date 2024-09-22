<?php

namespace App\Http\Controllers;

use App\Exports\OrderItemsExport;
use App\Models\Item;
use App\Models\OrderItem;
use App\Models\Patient;
use App\Rules\NotAlreadyOrdered;
use App\Rules\NotGreaterThanItemQuantity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create(Patient $patient)
    {
        $items = Item::query()
            ->when(FacadesRequest::input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->withQueryString();

        $full_name = $patient->full_name;

        return Inertia::render('OrderItems/Create', [
            'items' => $items,
            'full_name' => $full_name,
            'patient_id' => $patient->id,
            'filters' => FacadesRequest::only(['search'])
        ]);
    }


    public function store(Request $request, Patient $patient)
    {
        $validated = $this->validate($request, [
            'orderItems.*.id' => ['required', 'exists:items,id', new NotAlreadyOrdered($patient->id)],
            'orderItems.*.order_quantity' => ['required', 'integer', 'min:1', new NotGreaterThanItemQuantity($request->input('orderItems'))],
            'orderItems.*.instruction' => ['nullable', 'string', 'max:500'],
            'patientId' => 'required|exists:patients,id'
        ]);

        DB::transaction(function () use ($validated, $patient) {

            foreach ($validated['orderItems'] as $orderItemData) {
                $itemId = $orderItemData['id'];
                $item = Item::findOrFail($itemId);

                $item->quantity -= $orderItemData['order_quantity'];
                $item->save();

                OrderItem::create([
                    'patient_id' => $patient->id, // Assuming you have the patient ID
                    'item_id' => $item->id,
                    'quantity' => $orderItemData['order_quantity'],
                    'instruction' => $orderItemData['instruction'],
                ]);
            }
        });

        return redirect()->route('patients.show', $patient->id)->with('message', 'Successfully added Order(s)');
    }


    public function edit(Item $item)
    {
        return Inertia::render('Items/Edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        $item = Item::findOrFail($orderItem->item_id);

        DB::transaction(function () use ($request, $orderItem, $item) {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1',
                'instruction' =>  ['nullable', 'string', 'max:500'],
            ]);

            $quantityDifference = $validated['quantity'] - $orderItem->quantity;

            // Validation for sufficient item quantity
            if ($item->quantity - $quantityDifference < 0) {
                // Throw validation error
                $availableQty = $item->quantity + $orderItem->quantity;
                throw ValidationException::withMessages([
                    'quantity' => "$item->name available quantity ({$availableQty})pcs is not sufficient.",

                ]);
            }

            // Update OrderItem quantity
            $orderItem->update($validated);

            // Adjust Item quantity
            $item->update(['quantity' => $item->quantity - $quantityDifference]);
        });
        // return redirect()->back()->with('message', 'test flash for redirect back OrderItemUpdate');
        return redirect()->route('patients.show', $orderItem->patient->id)->with('message', 'Successfully added Order(s)');
    }

    public function destroy(OrderItem $orderItem)
    {
        //remove specific order
        DB::transaction(function () use ($orderItem) {
            $item = Item::findOrFail($orderItem->item_id);
            $orderItemQty = $orderItem->quantity;
            $item->update(['quantity' => $item->quantity + $orderItemQty]);
            $orderItem->delete();
        });
    }

    public function export(Request $request)
    {
        $date = $request->input('date');

        if (!$date) {
            // Return a forbidden response
            abort(403, 'Date is required.');
        }

        return Excel::download(new OrderItemsExport($date), 'patientOrders.xlsx');
    }
}
