<?php

declare(strict_types=1);

namespace Payouts\Payout\Domain\ValueObject;

use Payouts\Shared\Domain\ValueObject\IntValueObject;

final class PayoutStatus extends IntValueObject
{
    private const NEW = 0;

    public function __construct(int $value = self::NEW)
    {
        parent::__construct($value);
    }
}
