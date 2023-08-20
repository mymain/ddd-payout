<?php

declare(strict_types=1);

namespace Payouts\Payout\Query\GetPayouts;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Payouts\Payout\Domain\Payout;
use Payouts\Payout\Query\DTO\PayoutsDTO;
use Payouts\Shared\Domain\Bus\Query\QueryHandler;
use Payouts\Shared\Domain\Bus\Query\Response;

final class GetPayoutsQueryHandler implements QueryHandler
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(GetPayoutsQuery $query): ?Response
    {
        $queryBuilder = $this->buildQuery($query);

        $payouts = $this->entityManager->getConnection()
            ->executeQuery($queryBuilder->getSQL(), $queryBuilder->getParameters())
            ->fetchAllAssociative();

        $payoutsDto = new PayoutsDTO();

        foreach ($payouts as $payout) {
            $payoutsDto->add(Payout::fromArray($payout));
        }

        return $payoutsDto;
    }

    private function buildQuery(GetPayoutsQuery $query): QueryBuilder
    {
        return $this->entityManager->getConnection()->createQueryBuilder()
            ->select([
                'p.uuid',
                'p.name',
                'p.email',
                'p.amount',
                'p.status',
                'p.bank_account_number AS bankAccountNumber',
                'p.created_at AS createdAt'
            ])
            ->from($this->entityManager->getClassMetadata(Payout::class)->getTableName(), 'p');
    }
}
