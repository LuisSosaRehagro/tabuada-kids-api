<?php

namespace App\Domain\ValueObjects;

enum TableStatus: string
{
    case INICIANTE = 'iniciante';
    case ESTUDANTE = 'estudante';
    case PRO       = 'pro';

    public function label(): string
    {
        return match($this) {
            self::INICIANTE => 'Iniciante',
            self::ESTUDANTE => 'Estudante',
            self::PRO       => 'PRO',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::INICIANTE => '#9CA3AF',
            self::ESTUDANTE => '#2A6FDB',
            self::PRO       => '#FFD700',
        };
    }
}
