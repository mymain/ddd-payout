<?php

declare(strict_types=1);

namespace Payouts\EventLogger\Repository;

use Payouts\EventLogger\Domain\EventLog;

interface EventLoggerRepository
{
    public function save(EventLog $eventLog): void;
}
