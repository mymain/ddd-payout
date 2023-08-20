<?php

declare(strict_types=1);

namespace Payouts\Shared\Domain\Bus\Event;

interface EventBus
{
    public function publish(Event ...$events): void;
}
