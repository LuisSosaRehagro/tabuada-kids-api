<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class TableNumber
{
    public readonly int $value;

    public function __construct(int $value)
    {
        if ($value < 1 || $value > 10) {
            throw new InvalidArgumentException("TableNumber must be between 1 and 10, got: {$value}");
        }
        $this->value = $value;
    }
}
