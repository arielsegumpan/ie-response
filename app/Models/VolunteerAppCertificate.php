<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VolunteerAppCertificate extends Model
{
    protected $fillable = [
        'volunteer_id',
        'name',
        'issued_at',
        'expires_at',
        'issuer',
    ];

    protected $casts = [
        'issued_at' => 'date',
        'expires_at' => 'date',
    ];

    public function volunteer() : BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }
}
