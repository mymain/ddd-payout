<?php

declare(strict_types=1);

namespace App\Controller\Payouts;

use Payouts\Payout\Command\CreatePayoutCommand;
use Payouts\Payout\Domain\Exception\DuplicatedPayoutException;
use Payouts\Payout\Query\GetPayouts\GetPayoutsQuery;
use Payouts\Shared\Domain\Bus\Command\CommandBus;
use Payouts\Shared\Domain\Bus\Query\QueryBus;
use Payouts\Shared\Infrastructure\Http\ErrorResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\InvalidArgumentException;

class PayoutsListController
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function __invoke(): Response
    {
        dd($this->queryBus->ask(new GetPayoutsQuery()));
    }
}
