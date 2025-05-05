<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Assessment extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'title',
        'description',
        'difficulty_level',
        'passing_percent',
        'auto_grade',
        'access',
        'has_timer',
        'duration_minutes',
        'category_id',
        'user_id',
    ];

    protected $casts = [
        'auto_grade' => 'boolean',
        'has_timer' => 'boolean',
        'difficulty_level' => 'integer',
        'passing_percent' => 'integer',
        'duration_minutes' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($assessment) {
            $assessment->code = self::generateUniqueCode();
        });

        static::saving(function ($assessment) {
            if ($assessment->has_timer && empty($assessment->duration_minutes)) {
                throw new \Exception("Duration is required when timer is enabled.");
            }
        });
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return array_merge($this->toArray(), [
            'code' => (string) $this->code,
        ]);
    }

    private static function generateUniqueCode(): string
    {
        do {
            $code = strtoupper(Str::random(16));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
