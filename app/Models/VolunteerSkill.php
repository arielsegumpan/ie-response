<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VolunteerSkill extends Model
{
    protected $fillable = [
        'volunteer_id',
        'skill_id',
        'proficiency_level',
        'certification_date',
        'expiration_date',
    ];

    public $incrementing = true;

    public function skill() : BelongsTo
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    public function volunteer() : BelongsTo
    {
        return $this->belongsTo(Volunteer::class, 'volunteer_id');
    }
}
