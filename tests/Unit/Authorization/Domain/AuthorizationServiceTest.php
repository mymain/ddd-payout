<?php

declare(strict_types=1);

namespace Tests\Unit\Authorization\Domain;

use DG\BypassFinals;
use Payouts\Authorization\Domain\AuthorizationService;
use Payouts\Authorization\Domain\Handler\HandlerInterface;
use Payouts\Authorization\Domain\Result\Authorized;
use Payouts\Authorization\Domain\Result\Unauthorized;
use Payouts\Payout\Domain\Payout;
use PHPUnit\Framework\TestCase;

final class AuthorizationServiceTest extends TestCase
{
    private AuthorizationService $object;

    private Payout $payoutMock;
    private HandlerInterface $handler1Mock;
    private HandlerInterface $handler2Mock;

    public function setUp(): void
    {
        BypassFinals::enable();

        $this->payoutMock = $this->createMock(Payout::class);
        $this->handler1Mock = $this->createMock(HandlerInterface::class);
        $this->handler2Mock = $this->createMock(HandlerInterface::class);

        $this->object = new AuthorizationService([$this->handler1Mock, $this->handler2Mock]);
    }

    public function testAuthorized(): void
    {
        $this->handler1Mock->expects($this->once())
            ->method('handle')
            ->willReturn(true);

        $this->handler2Mock->expects($this->once())
            ->method('handle')
            ->willReturn(true);

        $this->assertInstanceOf(Authorized::class, $this->object->authorize($this->payoutMock));
    }

    public function testUnauthorized(): void
    {
        $this->handler1Mock->expects($this->once())
            ->method('handle')
            ->willReturn(false);

        $this->handler2Mock->expects($this->once())
            ->method('handle')
            ->willReturn(true);

        $this->assertInstanceOf(Unauthorized::class, $this->object->authorize($this->payoutMock));
    }
}
