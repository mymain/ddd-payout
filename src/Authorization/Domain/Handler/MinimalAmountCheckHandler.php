<?php

declare(strict_types=1);

namespace Payouts\Authorization\Domain\Handler;

use Payouts\Payout\Domain\Payout;
use Payouts\Shared\Domain\ValueObject\IntValueObject;

final class MinimalAmountCheckHandler implements HandlerInterface
{
    private const MINIMAL_AMOUNT = 10;

    public function handle(Payout $payout): bool
    {
        return $payout->amount()->lessThan(new IntValueObject(self::MINIMAL_AMOUNT));
    }
}
