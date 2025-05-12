<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Result extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'assessment_id',
        'user_id',
        'score',
        'status',
        'is_passed',
    ];

    protected $casts = [
        'score' => 'integer',
        'is_passed' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($result) {
            if (Auth::check()) {
                $result->user_id = Auth::id();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(ResultDetails::class);
    }
}
