<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'icon', 'is_active'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(History::class);
    }

    public function userBranches(): HasMany
    {
        return $this->hasMany(UserBranch::class);
    }
}
