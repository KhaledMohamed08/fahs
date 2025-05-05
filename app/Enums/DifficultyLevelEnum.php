<?php

namespace App\Enums;

enum DifficultyLevelEnum: int
{
    case EASY = 1;
    case MEDIUM = 2;
    case HARD = 3;

    public function label(): string
    {
        return match ($this) {
            self::EASY => 'Easy',
            self::MEDIUM => 'Medium',
            self::HARD => 'Hard',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::EASY => 'success',
            self::MEDIUM => 'warning',
            self::HARD => 'danger',
        };
    }
}
