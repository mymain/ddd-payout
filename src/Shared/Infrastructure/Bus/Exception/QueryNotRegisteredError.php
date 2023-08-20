<?php

declare(strict_types=1);

namespace Payouts\Shared\Infrastructure\Bus\Exception;

use Exception;
use Payouts\Shared\Domain\Bus\Query\Query;

class QueryNotRegisteredError extends Exception
{
    public function __construct(Query $query)
    {
        $message = sprintf(
            'Query with class %s has no handler registered',
            get_class($query)
        );

        parent::__construct($message);
    }
}
