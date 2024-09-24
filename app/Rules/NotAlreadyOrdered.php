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

    private $encounterId;

    public function __construct($encounterId)
    {
        $this->encounterId = $encounterId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $existingOrderItem = OrderItem::where('encounter_id', $this->encounterId)
            ->where('item_id', $value)
            ->first();

        if ($existingOrderItem) {
            // Eager load the related item to access its name efficiently
            $existingOrderItem->load('item');

            $fail("The item '{$existingOrderItem->item->name}' has already been ordered to this patient.");
        }
    }
}
