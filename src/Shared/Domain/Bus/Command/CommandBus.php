<?php

declare(strict_types=1);

namespace Payouts\Shared\Domain\Bus\Command;

interface CommandBus
{
    public function dispatch(Command $job): void;
}
