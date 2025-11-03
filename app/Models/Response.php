<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'responder_id',
        'response_type',
        'status',
        'assignment_date',
        'eta',
        'arrival_time',
        'completion_time',
        'notes',
    ];

    protected $casts = [
        'assignment_date' => 'datetime',
        'eta' => 'datetime',
        'arrival_time' => 'datetime',
        'completion_time' => 'datetime',
    ];

    public function incident() : BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }

    public function responder() : BelongsTo
    {
        return $this->belongsTo(User::class, 'responder_id');
    }
}
