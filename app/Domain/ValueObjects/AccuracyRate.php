<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class AccuracyRate
{
    public readonly float $value;

    public function __construct(float $value)
    {
        if ($value < 0.0 || $value > 100.0) {
            throw new InvalidArgumentException("AccuracyRate must be between 0 and 100, got: {$value}");
        }
        $this->value = round($value, 1);
    }

    public static function fromFraction(int $correct, int $total): self
    {
        if ($total === 0) {
            return new self(0.0);
        }
        return new self(($correct / $total) * 100);
    }
}
