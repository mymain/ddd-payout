<?php

declare(strict_types=1);

namespace Payouts\Payout\Domain\ValueObject;

use Payouts\Shared\Domain\ValueObject\IntValueObject;
use Webmozart\Assert\Assert;

final class PayoutAmount extends IntValueObject
{
    public function __construct(int $amount)
    {
        Assert::integer($amount);
        Assert::greaterThan($amount, 0);

        parent::__construct($amount);
    }
}
