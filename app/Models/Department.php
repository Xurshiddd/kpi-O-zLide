<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = ['name', 'category_id'];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
