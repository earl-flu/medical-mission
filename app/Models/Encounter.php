<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Encounter extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $guarded = ['id'];

    protected $appends = ['event_name'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

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
        // Access the event_id property directly
        $event_id = $this->event_id;

        // Ensure event_id is set before attempting to find the Event
        if ($event_id) {
            return Event::find($event_id)->name ?? null;
        }

        return null; // Return null if event_id is not set
    }
}
