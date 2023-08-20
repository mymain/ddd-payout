<?php

declare(strict_types=1);

namespace Payouts\Payout\Infrastructure\Persistence\Doctrine;

use Payouts\Payout\Domain\ValueObject\PayoutName;
use Payouts\Shared\Infrastructure\Persistence\Doctrine\NullableStringType;

class ValueObjectPayoutNameType extends NullableStringType
{
    protected function typeClassName(): string
    {
        return PayoutName::class;
    }
}
