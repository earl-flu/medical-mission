<?php

namespace App\Rules;

use App\Models\Item;
use App\Models\OrderItem;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotAlreadyOrdered implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    private $patientId;

    public function __construct($patientId)
    {
        $this->patientId = $patientId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // dd($value);
        $existingOrderItem = OrderItem::where('patient_id', $this->patientId)
            ->where('item_id', $value)
            ->first();
        // $itemName = Item::find($value)->get();

        if ($existingOrderItem) {
            // Eager load the related item to access its name efficiently
            $existingOrderItem->load('item');

            $fail("The item '{$existingOrderItem->item->name}' has already been ordered to this patient.");
        }
    }
}
