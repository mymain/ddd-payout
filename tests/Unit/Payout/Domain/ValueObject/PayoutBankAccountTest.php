<?php

declare(strict_types=1);

namespace App\Tests\Unit\Payout\Domain\ValueObject;

use Payouts\Payout\Domain\ValueObject\PayoutBankAccountNumber;
use PHPUnit\Framework\TestCase;
use TypeError;
use Webmozart\Assert\InvalidArgumentException;

final class PayoutBankAccountTest extends TestCase
{
    private PayoutBankAccountNumber $object;

    /**
     * @dataProvider payoutAmountTestDataProvider
     */
    public function testPayoutBankAccountNumber(
        mixed $bankAccountNumber,
        bool $valid,
        ?string $expectedException = null
    ): void {
        if (!$valid) {
            $this->expectException($expectedException);
        }

        $this->object = new PayoutBankAccountNumber($bankAccountNumber);

        $this->assertEquals($bankAccountNumber, $this->object->value());
    }

    public function payoutAmountTestDataProvider(): array
    {
        return [
            ['35202111090000000001234566', true],
            ['3520211109000000000123456', false, InvalidArgumentException::class],
            ['352021110900000000012345666', false, InvalidArgumentException::class],
            [0.1, false, TypeError::class],
            [1, false, TypeError::class],
        ];
    }
}
