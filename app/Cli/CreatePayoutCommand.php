<?php

declare(strict_types=1);

namespace App\Cli;

use Payouts\Payout\Domain\Exception\DuplicatedPayoutException;
use Payouts\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Webmozart\Assert\InvalidArgumentException;

#[AsCommand(
    name: 'payouts:create',
    description: 'Create payout command',
)]
final class CreatePayoutCommand extends Command
{
    public function __construct(private CommandBus $commandBus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $question = new Question('Please provide payout amount: ');

        $amount = (int) $helper->ask($input, $output, $question);

        $question = new Question('Please provide payout customer name: ');

        $name = $helper->ask($input, $output, $question);

        $question = new Question('Please provide payout customer email: ');

        $email = $helper->ask($input, $output, $question);

        $question = new Question('Please provide payout customer bank account number: ');

        $bankAccountNumber = $helper->ask($input, $output, $question);


        try {
            $this->commandBus->dispatch(new \Payouts\Payout\Command\CreatePayoutCommand($name, $email, $bankAccountNumber, $amount));

            return Command::SUCCESS;
        } catch (DuplicatedPayoutException|InvalidArgumentException $e) {
            return Command::FAILURE;
        }
    }
}
