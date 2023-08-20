<?php

declare(strict_types=1);

namespace App\Cli;

use Payouts\Shared\Infrastructure\Bus\Event\MySqlDoctrineEventConsumer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'payouts:domain-events:mysql:consume',
    description: 'Consume MySQL domain events.',
)]
final class ConsumeMySqlDomainEventsCommand extends Command
{
    private const QUANTITY_ARGUMENT = 'quantity';

    public function __construct(private MySqlDoctrineEventConsumer $consumer)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            self::QUANTITY_ARGUMENT,
            InputArgument::OPTIONAL,
            'Amount of events to process',
            100
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $quantity = (int) $input->getArgument(self::QUANTITY_ARGUMENT);
        $events = $this->consumer->getEventsToConsume($quantity);

        foreach ($events as $event) {
            try {
                $this->consumer->consume($event);
            } catch (\RuntimeException $exception) {
                $io->error($exception->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
