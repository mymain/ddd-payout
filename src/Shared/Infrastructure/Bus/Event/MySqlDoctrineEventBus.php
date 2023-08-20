<?php

declare(strict_types=1);

namespace Payouts\Shared\Infrastructure\Bus\Event;

use Payouts\Shared\Domain\Bus\Event\Event;
use Payouts\Shared\Domain\Bus\Event\EventBus;
use Payouts\Shared\Domain\Utils;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

use function Lambdish\Phunctional\each;

final class MySqlDoctrineEventBus implements EventBus
{
    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    public function publish(Event ...$events): void
    {
        each($this->execute(), $events);
    }

    private function execute(): callable
    {
        return function (Event $event): void {
            $id = $this->connection->quote($event->eventId());
            $aggregateId = $this->connection->quote($event->aggregateId());
            $name = $this->connection->quote($event::eventName());
            $body = $this->connection->quote(Utils::jsonEncode($event->toPrimitives()));
            $date = Utils::stringToDate($event->occurredOn());
            $ocurredOn = $this->connection->quote(Utils::dateToDatabaseString($date));

            $this->connection->executeStatement(
                'INSERT INTO events (id, aggregate_id, name,  body, created_at)' .
                "VALUES ($id, $aggregateId, $name, $body, $ocurredOn);"
            );
        };
    }
}
