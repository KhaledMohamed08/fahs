<?php

namespace App\Enums;

enum ResultStatusEnum: string
{
    case PENDING = 'pending';
    case REVIEWING = 'reviewing';
    case DONE = 'done';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::REVIEWING => 'Reviewing',
            self::DONE => 'Done',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::REVIEWING => 'danger',
            self::DONE => 'success',
        };
    }
}
