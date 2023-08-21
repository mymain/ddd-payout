<?php

declare(strict_types=1);

namespace Payouts\Shared\Domain\ValueObject;

class IntValueObject
{
    public function __construct(protected readonly int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }

    public function greaterThan(self $amount): bool
    {
        return $this->value > $amount->value();
    }

    public function lessThan(self $amount): bool
    {
        return $this->value < $amount->value();
    }
}
