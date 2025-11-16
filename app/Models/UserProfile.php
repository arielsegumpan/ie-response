<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Woenel\Prpcmblmts\Models\PhilippineCity;
use Woenel\Prpcmblmts\Models\PhilippineRegion;
use Woenel\Prpcmblmts\Models\PhilippineBarangay;
use Woenel\Prpcmblmts\Models\PhilippineProvince;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'emergency_contact',
        'emergency_contact_phone',
        'region_id',
        'province_id',
        'city_id',
        'barangay_id',
        'street',
        'full_address',
        'additional_info',
    ];

    protected $casts = [
        'additional_info' => 'array',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function region() : BelongsTo
    {
        return $this->belongsTo(PhilippineRegion::class);
    }

    public function province() : BelongsTo
    {
        return $this->belongsTo(PhilippineProvince::class);
    }

    public function city() : BelongsTo
    {
        return $this->belongsTo(PhilippineCity::class);
    }

    public function barangay() : BelongsTo
    {
        return $this->belongsTo(PhilippineBarangay::class);
    }
}
