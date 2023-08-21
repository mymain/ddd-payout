<?php

declare(strict_types=1);

namespace Payouts\Authorization\Domain\Handler;

use Payouts\Payout\Domain\Payout;
use Payouts\Shared\Domain\ValueObject\IntValueObject;

final class MaximalAmountCheckHandler implements HandlerInterface
{
    private const MAXIMAL_AMOUNT = 1000;

    public function handle(Payout $payout): bool
    {
        return $payout->amount()->greaterThan(
            new IntValueObject(self::MAXIMAL_AMOUNT)
        );
    }
}
