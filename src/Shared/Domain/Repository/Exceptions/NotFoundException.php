<?php

declare(strict_types=1);

namespace Payouts\Shared\Domain\Repository\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public function __construct(string $class)
    {
        parent::__construct(sprintf('Not found entity of class %s', $class));
    }
}
