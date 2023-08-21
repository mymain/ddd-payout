<?php

declare(strict_types=1);

namespace App\Cli;

use Payouts\Authorization\Domain\AuthorizationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'payouts:queue:authorization',
    description: 'Payout authorization command',
)]
final class AuthorizationCommand extends Command
{
    public function __construct(private readonly AuthorizationService $authorizationService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //$this->authorizationService->authorize($payout);

        return Command::SUCCESS;
    }
}