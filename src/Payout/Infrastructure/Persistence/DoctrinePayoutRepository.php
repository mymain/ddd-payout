<?php

declare(strict_types=1);

namespace Payouts\Payout\Infrastructure\Persistence;

use Payouts\Payout\Domain\Exception\DuplicatedPayoutException;
use Payouts\Payout\Domain\Payout;
use Payouts\Payout\Domain\ValueObject\PayoutUuid;
use Payouts\Payout\Repository\PayoutRepository;
use Payouts\Shared\Domain\Repository\Exceptions\NotFoundException;
use Payouts\Shared\Infrastructure\Persistence\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Payout findOneBy(array $parameters, array $sortBy = null)
 */
class DoctrinePayoutRepository extends DoctrineRepository implements PayoutRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Payout::class);
    }

    /**
     * @throws DuplicatedPayoutException
     */
    public function save(Payout $payout): void
    {
        try {
            if ($this->findByUuid($payout->uuid())) {
                throw new DuplicatedPayoutException();
            }
        } catch (NotFoundException $e) {
            $this->persist($payout);
        }
    }

    /**
     * @throws NotFoundException
     */
    public function findByUuid(PayoutUuid $uuid): Payout
    {
        return $this->findOneBy(['uuid' => $uuid]);
    }
}
