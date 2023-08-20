<?php

declare(strict_types=1);

namespace Payouts\EventLogger\Domain;

use Payouts\EventLogger\Domain\ValueObject\EventLogAggregateId;
use Payouts\EventLogger\Domain\ValueObject\EventLogBody;
use Payouts\EventLogger\Domain\ValueObject\EventLogCreatedAt;
use Payouts\EventLogger\Domain\ValueObject\EventLogName;
use Payouts\EventLogger\Domain\ValueObject\EventLogUuid;
use Payouts\Shared\Domain\Aggregate\AggregateRoot;
use Payouts\Shared\Domain\Bus\Event\Event;
use Payouts\Shared\Domain\Utils;

final class EventLog extends AggregateRoot
{
    public function __construct(
        public readonly EventLogUuid $id,
        public readonly EventLogAggregateId $aggregateId,
        public readonly EventLogName $name,
        public readonly EventLogBody $body,
        public ?EventLogCreatedAt $createdAt = null
    ) {
        $this->createdAt = $createdAt ?? new EventLogCreatedAt();
    }

    public static function createFromEvent(Event $event): self
    {
        return new self(
            new EventLogUuid($event->eventId()),
            new EventLogAggregateId($event->aggregateId()),
            new EventLogName($event::eventName()),
            new EventLogBody($event->toPrimitives())
        );
    }

    public function id(): EventLogUuid
    {
        return $this->id;
    }

    public function aggregateId(): EventLogAggregateId
    {
        return $this->aggregateId;
    }

    public function name(): EventLogName
    {
        return $this->name;
    }

    public function body(): EventLogBody
    {
        return $this->body;
    }

    public function createdAt(): EventLogCreatedAt
    {
        return $this->createdAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'aggregateId' => $this->aggregateId()->value(),
            'name' => $this->name()->value(),
            'body' => $this->body()->asArray(),
            'createdAt' => $this->createdAt()->value(),
        ];
    }

    public static function fromArray(array $parameters): self
    {
        return new self(
            new EventLogUuid($parameters['id']),
            new EventLogAggregateId($parameters['aggregateId']),
            new EventLogName($parameters['name']),
            new EventLogBody($parameters['body']),
            new EventLogCreatedAt(Utils::stringToDate($parameters['createdAt']))
        );
    }
}
