<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogCategory extends Model
{
    protected $fillable = [
        'blog_id',
        'category_id',
    ];

    public function blog() : BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
