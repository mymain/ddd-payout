<?php

declare(strict_types=1);

namespace Payouts\Payout\Domain\Exception;

use Exception;

class DuplicatedPayoutException extends Exception
{
    public function __construct()
    {
        parent::__construct('Duplicated payout');
    }
}
