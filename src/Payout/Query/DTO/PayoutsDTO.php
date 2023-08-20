<?php

declare(strict_types=1);

namespace Payouts\Payout\Query\DTO;

use Payouts\Payout\Domain\Payout;
use Payouts\Shared\Domain\Bus\Query\Response;

final class PayoutsDTO implements Response
{
    public function __construct(private array $payouts = [])
    {
    }

    public function add(Payout $payout): void
    {
        $this->payouts[] = $payout;
    }

    public function getAll(): array
    {
        return $this->payouts;
    }
}
