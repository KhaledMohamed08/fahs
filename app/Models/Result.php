<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    /** @use HasFactory<\Database\Factories\ResultFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'assessment_id',
        'user_id',
        'score',
        'status',
    ];

    protected $casts = [
        'score' => 'integer',
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
}
