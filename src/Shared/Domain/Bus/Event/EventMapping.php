<?php

declare(strict_types=1);

namespace Payouts\Shared\Domain\Bus\Event;

use Payouts\Shared\Domain\Exception\EventMappingException;

use function Lambdish\Phunctional\reindex;

final class EventMapping
{
    public function __construct(private array $mapping)
    {
        $this->mapping = reindex(fn (string $class) => ($class)::eventName(), $mapping);
    }

    public function for(string $name)
    {
        if (!isset($this->mapping[$name])) {
            throw new EventMappingException(sprintf('No event class mapped for %s', $name));
        }

        return $this->mapping[$name];
    }
}
