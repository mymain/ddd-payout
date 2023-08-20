<?php

declare(strict_types=1);

namespace Payouts\Shared\Domain\Aggregate;

use Payouts\Shared\Domain\Bus\Event\Event;

abstract class AggregateRoot
{
    private array $events = [];

    abstract public function toArray(): array;

    abstract public static function fromArray(array $parameters): self;

    final public function pullEvents(): array
    {
        $events = $this->events;

        $this->events = [];

        return $events;
    }

    final protected function record(Event $event): void
    {
        $this->events[] = $event;
    }
}
