<?php

declare(strict_types=1);

namespace Payouts\Shared\Domain\ValueObject;

use Payouts\Shared\Domain\Exception\InvalidJsonException;
use Payouts\Shared\Domain\Utils;

class JsonValue
{
    protected readonly string $value;

    public function __construct(array $value)
    {
        $this->value = Utils::jsonEncode($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function asArray(): array
    {
        return Utils::jsonDecode($this->value);
    }

    private function throwIsInvalid(string $value)
    {
        $valid = !((Utils::jsonDecode($value) == null));

        if (false === $valid) {
            throw new InvalidJsonException($value);
        }
    }
}
