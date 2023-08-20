<?php

declare(strict_types=1);

namespace App\Tests\Unit\Payout\Domain\ValueObject;

use Payouts\Payout\Domain\ValueObject\PayoutAmount;
use PHPUnit\Framework\TestCase;
use TypeError;
use Webmozart\Assert\InvalidArgumentException;

final class PayoutAmountTest extends TestCase
{
    private PayoutAmount $object;

    /**
     * @dataProvider payoutAmountTestDataProvider
     */
    public function testPayoutAmount(mixed $amount, bool $valid, ?string $expectedException = null): void
    {
        if (!$valid) {
            $this->expectException($expectedException);
        }

        $this->object = new PayoutAmount($amount);

        $this->assertEquals($amount, $this->object->value());
    }

    public function payoutAmountTestDataProvider(): array
    {
        return [
            [123, true],
            [-123, false, InvalidArgumentException::class],
            [0.1, false, TypeError::class],
            ['1', false, TypeError::class],
            ['1.0', false, TypeError::class],
            ['abc', false, TypeError::class],
        ];
    }
}
