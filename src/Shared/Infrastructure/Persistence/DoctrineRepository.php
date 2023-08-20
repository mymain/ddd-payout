<?php

declare(strict_types=1);

namespace Payouts\Shared\Infrastructure\Persistence;

use Payouts\Shared\Domain\Aggregate\AggregateRoot;
use Payouts\Shared\Domain\Repository\Exceptions\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class DoctrineRepository
{
    protected string $entityClass;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, string $entityClass)
    {
        $this->entityManager = $entityManager;
        $this->entityClass = $entityClass;
    }

    protected function entityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function persist(AggregateRoot $entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush();
    }

    protected function remove(AggregateRoot $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush();
    }

    protected function repository(): EntityRepository
    {
        return $this->entityManager->getRepository($this->entityClass);
    }

    /**
     * @throws NotFoundException
     */
    public function findOneBy(array $parameters, ?array $sortBy = null)
    {
        $entity = $this->repository()->findOneBy($parameters, $sortBy);

        if (!$entity) {
            throw new NotFoundException($this->entityClass);
        }

        return $entity;
    }
}
