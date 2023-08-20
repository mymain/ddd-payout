<?php

declare(strict_types=1);

namespace App\Cli;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(
    name: 'payouts:queue:authorization',
    description: 'Payout authorization command',
)]
final class AuthorizationCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }
}