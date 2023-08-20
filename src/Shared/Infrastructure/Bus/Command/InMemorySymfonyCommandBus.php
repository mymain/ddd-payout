<?php

declare(strict_types=1);

namespace Payouts\Shared\Infrastructure\Bus\Command;

use Payouts\Shared\Domain\Bus\Command\Command;
use Payouts\Shared\Domain\Bus\Command\CommandBus;
use Payouts\Shared\Infrastructure\Bus\Exception\CommandNotRegisteredError;
use Payouts\Shared\Infrastructure\Bus\GetHandlersByFirstParameter;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class InMemorySymfonyCommandBus implements CommandBus
{
    private MessageBus $bus;

    public function __construct(iterable $commandHandlers)
    {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(GetHandlersByFirstParameter::forCallables($commandHandlers))
            ),
        ]);
    }

    public function dispatch(Command $job): void
    {
        try {
            $this->bus->dispatch($job);
        } catch (NoHandlerForMessageException $unused) {
            throw new CommandNotRegisteredError($job);
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious();
        }
    }
}
