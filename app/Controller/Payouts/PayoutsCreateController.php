<?php

declare(strict_types=1);

namespace App\Controller\Payouts;

use Payouts\Payout\Command\CreatePayoutCommand;
use Payouts\Payout\Domain\Exception\DuplicatedPayoutException;
use Payouts\Shared\Domain\Bus\Command\CommandBus;
use Payouts\Shared\Infrastructure\Http\ErrorResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\InvalidArgumentException;

class PayoutsCreateController
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    public function __invoke(Request $request): Response
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $amount = (int) $request->get('amount');
        $bankAccountNumber = $request->get('bankAccountNumber');

        try {
            $this->commandBus->dispatch(new CreatePayoutCommand($name, $email, $bankAccountNumber, $amount));

            return new Response(null, Response::HTTP_CREATED);
        } catch (DuplicatedPayoutException|InvalidArgumentException $e) {
            return new ErrorResponse($e, Response::HTTP_BAD_REQUEST);
        }
    }
}
