<?php

declare(strict_types=1);

namespace Payouts\Payout\Domain\Event;

use Payouts\Shared\Domain\Bus\Event\EventSubscriber;

class PayoutCreatedEventSubscriber implements EventSubscriber
{
    public function __construct()
    {
    }

    public function __invoke(PayoutCreatedEvent $event): void
    {
        //@todo push it to authorization queue
    }

    public static function subscribedTo(): array
    {
        return [PayoutCreatedEvent::class];
    }
}
