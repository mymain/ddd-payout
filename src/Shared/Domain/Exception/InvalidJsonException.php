<?php

declare(strict_types=1);

namespace Payouts\Shared\Domain\Exception;

use Exception;
use Throwable;

class InvalidJsonException extends Exception
{
    public function __construct(string $json = '', int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf('The string provided its not a valid json format: %s', $json);

        parent::__construct($message, $code, $previous);
    }
}
