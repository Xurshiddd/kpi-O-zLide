<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Criterion extends Model
{
    protected $fillable = ['name','department_id', 'score'];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
