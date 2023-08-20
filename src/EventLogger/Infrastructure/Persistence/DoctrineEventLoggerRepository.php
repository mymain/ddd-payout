<?php

declare(strict_types=1);

namespace Payouts\EventLogger\Infrastructure\Persistence;

use Payouts\EventLogger\Domain\EventLog;
use Payouts\EventLogger\Repository\EventLoggerRepository;
use Payouts\Shared\Infrastructure\Persistence\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineEventLoggerRepository extends DoctrineRepository implements EventLoggerRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, EventLog::class);
    }

    public function save(EventLog $eventLog): void
    {
        $this->persist($eventLog);
    }
}
