<?php

declare(strict_types=1);

namespace Payouts\Payout\Command;

use Payouts\Shared\Domain\Bus\Command\Command;

final class CreatePayoutCommand implements Command
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $bankAccountNumber,
        private readonly int $amount,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function bankAccountNumber(): string
    {
        return $this->bankAccountNumber;
    }

    public function amount(): int
    {
        return $this->amount;
    }
}
