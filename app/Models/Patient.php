<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Patient extends Model
{
    use LogsActivity;
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['full_name', 'full_address', 'age_years', 'sex_str', 'birthdate_str'];

    const MALE = 1;
    const FEMALE = 0;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    //under 18 = pedia
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function encounters()
    {
        return $this->hasMany(Encounter::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getFullNameAttribute()
    {
        $middle_name = $this->attributes['middle_name'] ?? '';
        $first_name = $this->attributes['first_name'];
        $last_name = $this->attributes['last_name'];
        $suffix = $this->attributes['suffix'] ?? '';
        return  trim("{$first_name} {$middle_name} {$last_name} {$suffix}");
    }

    public function getMunicipalityStrAttribute()
    {
        $city_id = $this->attributes['city_id'];
        $city = City::find($city_id)->name;
        return $city;
    }

    public function getBarangayStrAttribute()
    {
        $barangay_id = $this->attributes['barangay_id'];
        $barangay = Barangay::find($barangay_id)->name;
        return $barangay;
    }

    public function getFullAddressAttribute()
    {

        $city_id = $this->attributes['city_id'];
        $barangay_id = $this->attributes['barangay_id'];

        $city = City::find($city_id)->name;
        $barangay = Barangay::find($barangay_id)->name;
        return "$city, $barangay";
    }

    public function getAgeYearsAttribute()
    {
        $age = Carbon::parse($this->attributes['birthdate'])->age;
        return "$age yrs old";
    }

    public function getSexStrAttribute()
    {
        $sex = $this->attributes['sex'];

        return $sex == self::MALE ? 'Male' : 'Female';
    }

    public function getBirthdateStrAttribute()
    {
        $birthdate = $this->attributes['birthdate'];
        $formattedBirthdate = Carbon::createFromFormat('Y-m-d', $birthdate)->isoFormat('MMM. D, YYYY');
        return $formattedBirthdate;
    }
}
