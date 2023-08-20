<?php

declare(strict_types=1);

namespace Payouts\Payout\Repository;

use Payouts\Payout\Domain\Payout;
use Payouts\Payout\Domain\ValueObject\PayoutUuid;

interface PayoutRepository
{
    public function save(Payout $payout): void;

    public function findByUuid(PayoutUuid $uuid): Payout;
}
