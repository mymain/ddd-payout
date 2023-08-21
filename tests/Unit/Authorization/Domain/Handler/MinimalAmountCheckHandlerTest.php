<?php

declare(strict_types=1);

namespace Tests\Unit\Authorization\Domain\Handler;

use DG\BypassFinals;
use Payouts\Authorization\Domain\Handler\MinimalAmountCheckHandler;
use Payouts\Payout\Domain\Payout;
use Payouts\Payout\Domain\ValueObject\PayoutAmount;
use PHPUnit\Framework\TestCase;

final class MinimalAmountCheckHandlerTest extends TestCase
{
    private MinimalAmountCheckHandler $object;

    private Payout $payoutMock;

    public function setUp(): void
    {
        BypassFinals::enable();

        $this->payoutMock = $this->createMock(Payout::class);

        $this->object = new MinimalAmountCheckHandler();
    }

    /**
     * @dataProvider minimalAmountCheckHandlerTestDataProvider
     */
    public function testMinimalAmountCheckHandler(int $amount, bool $lessThan): void
    {
        $payoutAmount = new PayoutAmount($amount);

        $this->payoutMock->expects($this->once())
            ->method('amount')
            ->willReturn($payoutAmount);

        $this->assertEquals($lessThan, $this->object->handle($this->payoutMock));
    }

    public function minimalAmountCheckHandlerTestDataProvider(): array
    {
        return [
            [1, true],
            [9, true],
            [10, false],
            [11, false],
        ];
    }
}
