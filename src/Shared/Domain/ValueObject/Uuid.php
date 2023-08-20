<?php

declare(strict_types=1);

namespace Payouts\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as BaseUuid;

class Uuid
{
    public function __construct(protected readonly string $id)
    {
        if (!$this->isValid($id)) {
            throw new InvalidArgumentException(
                sprintf('%s does not allow the value %s.', static::class, $id)
            );
        }
    }

    public static function generate(): string
    {
        return BaseUuid::uuid4()->toString();
    }

    public function value(): string
    {
        return $this->id;
    }

    private function isValid(string $id): bool
    {
        return BaseUuid::isValid($id);
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
