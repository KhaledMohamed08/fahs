<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'duration_minutes',
        'category_id',
        'user_id',
        'is_active',
    ];

    protected $casts = [
        'auto_grade' => 'boolean',
        'difficulty_level' => 'integer',
        'passing_percent' => 'integer',
        'duration_minutes' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($assessment) {
            $assessment->code = self::generateUniqueCode();
            if (Auth::check()) {
                $assessment->user_id = Auth::id();
            }
        });

        // static::addGlobalScope('active', function (Builder $builder) {
        //     $builder->where('is_active', true);
        // });
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function questionsPerType(string $type): Collection
    {
        return $this->questions->where('type', $type);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function fullScore(): int
    {
        return $this->questions->sum(function ($question) {
            return $question->score;
        });
    }

    public function isPassed($score): bool
    {
        $fullScore = $this->fullScore();
        $requiredScore = ($this->passing_percent / 100) * $fullScore;

        return $score >= $requiredScore;
    }
}
