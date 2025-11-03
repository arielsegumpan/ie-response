<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_name',
        'organization_type_id',
        'org_email',
        'org_contact_person',
        'org_contact_phone',
        'org_contact_email',
        'org_img',
        'org_description',
    ];

    public function type() : BelongsTo
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type_id');
    }

    public function volunteers() : HasMany
    {
        return $this->hasMany(Volunteer::class);
    }

    public function organizationType() : BelongsTo
    {
        return $this->belongsTo(OrganizationType::class);
    }
}
