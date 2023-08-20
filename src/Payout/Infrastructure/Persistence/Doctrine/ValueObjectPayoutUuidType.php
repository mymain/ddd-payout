<?php

declare(strict_types=1);

namespace Payouts\Payout\Infrastructure\Persistence\Doctrine;

use Payouts\Payout\Domain\ValueObject\PayoutUuid;
use Payouts\Shared\Infrastructure\Persistence\Doctrine\UuidType;

class ValueObjectPayoutUuidType extends UuidType
{
    protected function typeClassName(): string
    {
        return PayoutUuid::class;
    }
}
