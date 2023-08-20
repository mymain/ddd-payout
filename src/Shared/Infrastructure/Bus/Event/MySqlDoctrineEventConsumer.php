<?php

declare(strict_types=1);

namespace Payouts\Shared\Infrastructure\Bus\Event;

use Payouts\Shared\Domain\Bus\Event\Event;
use Payouts\Shared\Domain\Bus\Event\EventMapping;
use Payouts\Shared\Domain\Utils;
use Payouts\Shared\Infrastructure\Bus\GetPipedHandlers;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

use function Lambdish\Phunctional\map;

final class MySqlDoctrineEventConsumer
{
    private Connection $connection;
    private MessageBus $bus;

    public function __construct(
        iterable $commandHandlers,
        EntityManagerInterface $entityManager,
        private EventMapping $eventBuilder,
    ) {
        $this->connection = $entityManager->getConnection();
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(GetPipedHandlers::forPipedCallables($commandHandlers))
            ),
        ]);
    }

    public function consume(Event $event): void
    {
        try {
            $this->bus->dispatch($event);
        } catch (NoHandlerForMessageException $exception) {
        }
    }

    /** @return Event[] */
    public function getEventsToConsume(int $quantity = 100): array
    {
        $rawEvents = $this->connection
            ->executeQuery("SELECT * FROM events ORDER BY created_at LIMIT $quantity")
            ->fetchAllAssociative();

        return map($this->constructEvent(), $rawEvents);
    }

    private function constructEvent(): callable
    {
        return function (array $rawEvent): Event {
            $class = $this->eventBuilder->for($rawEvent['name']);

            return ($class)::fromPrimitives(
                $rawEvent['aggregate_id'],
                Utils::jsonDecode($rawEvent['body']),
                $rawEvent['id'],
                $rawEvent['created_at']
            );
        };
    }
}
