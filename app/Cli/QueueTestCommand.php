<?php

declare(strict_types=1);

namespace App\Cli;

use Payouts\Payout\Domain\Event\PayoutAuthorizationEvent;
use Payouts\Payout\Domain\ValueObject\PayoutUuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'payouts:queue:test',
    description: 'Queues testing command',
)]
final class QueueTestCommand extends Command
{
    public function __construct(private MessageBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->bus->dispatch(
            new PayoutAuthorizationEvent(
                new PayoutUuid('c1253389-d078-46f4-8375-c30444ad8ab2')
            )
        );

        return Command::SUCCESS;
    }
}
