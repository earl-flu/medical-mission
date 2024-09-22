<?php

namespace App\Rules;

use App\Models\Item;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotGreaterThanItemQuantity implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $orderItems;

    public function __construct($orderItems)
    {

        $this->orderItems = $orderItems;
    }


    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Extract index more reliably using regular expression
        // preg_match('/items\.(\d+)\.cart_quantity/', $attribute, $matches);
        // $attributeIndex = $matches[1];
        $attributeIndex = explode('.', $attribute)[1];

        // Retrieve item ID and quantity directly from orderItems array
        $itemId = $this->orderItems[$attributeIndex]['id'];
        $requestedQuantity = $value;

        // Eager load the item relationship for efficiency
        $item = Item::with('orderItems')->find($itemId);

        // Calculate available quantity considering existing order items
        $availableQuantity = $item->quantity - $item->orderItems->sum('order_quantity');

        if ($requestedQuantity > $availableQuantity) {
            $fail("{$item->name} has only {$availableQuantity} available.");
        }
    }

    // public function validate(string $attribute, mixed $value, Closure $fail): void
    // {
    //    //get the index of the request item eg "items.1.cart_quantity"
    //    $attributeIndex = explode('.', $attribute)[1];

    //    //get the id of the product using the index
    //    $itemId = $this->orderItems[$attributeIndex]['id'];

    //    //search for the availablequantity of product using itemId
    //    $item = Item::find($itemId);
    //    $availableQuantity = $item->quantity;

    //    if ($value > $availableQuantity) {
    //        $fail("{$item->name} available quantity is {$availableQuantity} only");
    //    }
    // }
}
