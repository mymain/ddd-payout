<?php

declare(strict_types=1);

namespace Payouts\Shared\Domain\Bus\Event;

use DateTime;
use Payouts\Shared\Domain\Utils;
use Payouts\Shared\Domain\ValueObject\Uuid;

abstract class Event
{
    private string $occurredOn;

    public function __construct(
        private string $aggregateId,
        private ?string $eventId = null,
        ?string $createdAt = null
    ) {
        $this->eventId = $eventId ?? Uuid::generate();
        $this->occurredOn = $createdAt ?? Utils::dateToString(new DateTime());
    }

    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $createdAt
    ): self;

    abstract public static function eventName(): string;

    abstract public function toPrimitives(): array;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function setEventIdIfNull(string $id)
    {
        $this->eventId ??= $id;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
