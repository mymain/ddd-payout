<?php

declare(strict_types=1);

namespace Payouts\Payout\Command;

use Payouts\Payout\Domain\Payout;
use Payouts\Payout\Domain\ValueObject\PayoutAmount;
use Payouts\Payout\Domain\ValueObject\PayoutBankAccountNumber;
use Payouts\Payout\Domain\ValueObject\PayoutEmail;
use Payouts\Payout\Domain\ValueObject\PayoutName;
use Payouts\Payout\Domain\ValueObject\PayoutStatus;
use Payouts\Payout\Domain\ValueObject\PayoutUuid;
use Payouts\Payout\Repository\PayoutRepository;
use Payouts\Shared\Domain\Bus\Command\CommandHandler;
use Payouts\Shared\Domain\Bus\Event\EventBus;
use Payouts\Shared\Domain\ValueObject\Uuid;

final class CreatePayoutCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly PayoutRepository $repository,
        private readonly EventBus $eventBus,
    ) {
    }

    public function __invoke(CreatePayoutCommand $command): Payout
    {
        $payout = Payout::create(
            new PayoutUuid(Uuid::generate()),
            new PayoutName($command->name()),
            new PayoutEmail($command->email()),
            new PayoutBankAccountNumber($command->bankAccountNumber()),
            new PayoutAmount($command->amount()),
            new PayoutStatus(),
        );

        $this->repository->save($payout);

        $this->eventBus->publish(...$payout->pullEvents());

        return $payout;
    }
}
