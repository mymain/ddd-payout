<?php

declare(strict_types=1);

namespace Payouts\Payout\Domain\ValueObject;

use Payouts\Shared\Domain\ValueObject\StringValueObject;
use Webmozart\Assert\Assert;

final class PayoutBankAccountNumber extends StringValueObject
{
    public function __construct(string $bankAccountNumber)
    {
        Assert::string($bankAccountNumber);
        Assert::length($bankAccountNumber, 26);

        parent::__construct($bankAccountNumber);
    }
}
