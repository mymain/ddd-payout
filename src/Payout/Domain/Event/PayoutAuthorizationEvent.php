<?php

declare(strict_types=1);

namespace Payouts\Payout\Domain\Event;

use Payouts\Payout\Domain\ValueObject\PayoutUuid;

class PayoutAuthorizationEvent
{
    public function __construct(private readonly PayoutUuid $uuid)
    {
    }

    public function uuid(): PayoutUuid
    {
        return $this->uuid;
    }
}
