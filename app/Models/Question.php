<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'assessment_id',
        'type',
        'title',
        'is_true',
        'options',
        'text_answer_model',
        'score',
    ];

    protected $casts = [
        'options' => 'array',
        'is_true' => 'boolean',
        'score' => 'integer',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }
}
