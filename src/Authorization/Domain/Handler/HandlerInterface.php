<?php

declare(strict_types=1);

namespace Payouts\Authorization\Domain\Handler;

use Payouts\Payout\Domain\Payout;

interface HandlerInterface
{
    public function handle(Payout $payout): bool;
}
