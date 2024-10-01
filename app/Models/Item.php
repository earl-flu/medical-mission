<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Item extends Model
{
    use LogsActivity;
    use HasFactory;
    
    protected $guarded = ['id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function orderItems()
    {
        // Define a one-to-many relationship with OrderItem
        return $this->hasMany(OrderItem::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
