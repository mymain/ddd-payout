<?php

declare(strict_types=1);

namespace Payouts\Authorization\Domain;

use Payouts\Authorization\Domain\Handler\HandlerInterface;
use Payouts\Authorization\Domain\Result\Authorized;
use Payouts\Authorization\Domain\Result\Unauthorized;
use Payouts\Payout\Domain\Payout;

final class AuthorizationService
{
    public function __construct(
        /** @var $handlers iterable<HandlerInterface> */
        private readonly iterable $handlers,
    ) {
    }

    public function authorize(Payout $payout): Authorized|Unauthorized
    {
        $authorized = true;

        /** @var $handler HandlerInterface */
        foreach ($this->handlers as $handler) {
            $authorized &= $handler->handle($payout);
        }

        if ($authorized) {
            return new Authorized();
        }

        return new Unauthorized();
    }
}
