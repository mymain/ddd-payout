<?php

declare(strict_types=1);

namespace Payouts\EventLogger\Domain\Bus\Event;

use Payouts\EventLogger\Domain\EventLog;
use Payouts\EventLogger\Repository\EventLoggerRepository;
use Payouts\Shared\Domain\Bus\Event\Event;
use Payouts\Shared\Domain\Bus\Event\EventSubscriber;

class EventLogEventSubscriber implements EventSubscriber
{
    public function __construct(private EventLoggerRepository $repository)
    {
    }

    public function __invoke(Event $event): void
    {
        $eventLog = EventLog::createFromEvent($event);

        $this->repository->save($eventLog);
    }

    public static function subscribedTo(): array
    {
        return [Event::class];
    }
}
