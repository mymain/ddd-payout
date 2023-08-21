<?php

declare(strict_types=1);

namespace Tests\Unit\Authorization\Domain\Handler;

use DG\BypassFinals;
use Payouts\Authorization\Domain\Handler\MaximalAmountCheckHandler;
use Payouts\Payout\Domain\Payout;
use Payouts\Payout\Domain\ValueObject\PayoutAmount;
use PHPUnit\Framework\TestCase;

final class MaximalAmountCheckHandlerTest extends TestCase
{
    private MaximalAmountCheckHandler $object;

    private Payout $payoutMock;

    public function setUp(): void
    {
        BypassFinals::enable();

        $this->payoutMock = $this->createMock(Payout::class);

        $this->object = new MaximalAmountCheckHandler();
    }

    /**
     * @dataProvider maximalAmountCheckHandlerTestDataProvider
     */
    public function testMaximalAmountCheckHandler(int $amount, bool $graterThan): void
    {
        $payoutAmount = new PayoutAmount($amount);

        $this->payoutMock->expects($this->once())
            ->method('amount')
            ->willReturn($payoutAmount);

        $this->assertEquals($graterThan, $this->object->handle($this->payoutMock));
    }

    public function maximalAmountCheckHandlerTestDataProvider(): array
    {
        return [
            [1000, false],
            [1001, true],
        ];
    }
}
