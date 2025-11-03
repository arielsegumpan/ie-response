<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkillCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill_cat_name',
        'skill_cat_description',
    ];

    public function skills() : HasMany
    {
        return $this->hasMany(Skill::class, 'skill_category_id');
    }
}
