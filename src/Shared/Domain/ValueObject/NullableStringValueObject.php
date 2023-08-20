<?php

declare(strict_types=1);

namespace Payouts\Shared\Domain\ValueObject;

class NullableStringValueObject
{
    public function __construct(protected readonly ?string $value)
    {
    }

    public function value(): ?string
    {
        return $this->value;
    }
}
