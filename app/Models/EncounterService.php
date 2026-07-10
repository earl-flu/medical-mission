<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncounterService extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'encounter_service';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'encounter_id',
        'service_id',
        'is_serve',
    ];

    // INSERT_YOUR_CODE
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
