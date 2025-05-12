<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultDetails extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'result_id',
        'question_id',
        'user_answer',
        'score',
    ];

    protected $casts = [
        'score' => 'integer',
    ];

    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
