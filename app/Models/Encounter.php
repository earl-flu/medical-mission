<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $appends = ['event_name'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    public function getEventNameAttribute()
    {
        $event_id = $this->attributes['event_id'];
        return Event::find($event_id)->name;
    }
}
