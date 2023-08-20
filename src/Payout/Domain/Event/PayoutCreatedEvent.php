<?php

declare(strict_types=1);

namespace Payouts\Payout\Domain\Event;

use Payouts\Payout\Domain\Payout;
use Payouts\Shared\Domain\Bus\Event\Event;

class PayoutCreatedEvent extends Event
{
    public function __construct(
        private readonly Payout $payout,
        ?string $eventId = null,
        ?string $createdAt = null,
    ) {
        parent::__construct($payout->uuid()->value(), $eventId, $createdAt);
    }

    public static function eventName(): string
    {
        return 'payouts.domain.payout.create';
    }

    public function toPrimitives(): array
    {
        return $this->payout->toArray();
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $createdAt,
    ): Event {
        return new self(
            Payout::fromArray($body),
            $eventId,
            $createdAt
        );
    }
}
