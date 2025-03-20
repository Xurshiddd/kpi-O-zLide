<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'type',
        'path',
        'user_id',
        'criteria_id',
        'score'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class, 'criteria_id');
    }
}
