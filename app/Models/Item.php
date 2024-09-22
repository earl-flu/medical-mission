<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function orderItems()
    {
        // Define a one-to-many relationship with OrderItem
        return $this->hasMany(OrderItem::class);
    }
}
