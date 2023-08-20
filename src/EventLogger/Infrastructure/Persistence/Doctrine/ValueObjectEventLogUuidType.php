<?php

declare(strict_types=1);

namespace Payouts\EventLogger\Infrastructure\Persistence\Doctrine;

use Payouts\EventLogger\Domain\ValueObject\EventLogUuid;
use Payouts\Shared\Infrastructure\Persistence\Doctrine\UuidType;

class ValueObjectEventLogUuidType extends UuidType
{
    protected function typeClassName(): string
    {
        return EventLogUuid::class;
    }
}
