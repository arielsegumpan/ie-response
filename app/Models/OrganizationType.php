<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_type_name',
        'org_type_description',
        'org_type_img',
    ];

    public function organizations() : HasMany
    {
        return $this->hasMany(Organization::class, 'organization_type_id');
    }
}
