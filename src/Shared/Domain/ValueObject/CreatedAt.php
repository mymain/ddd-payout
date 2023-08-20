<?php

declare(strict_types=1);

namespace Payouts\Shared\Domain\ValueObject;

use DateTime;
use Payouts\Shared\Domain\Utils;

class CreatedAt
{
    protected DateTime $date;

    public function __construct(?DateTime $date = null)
    {
        $this->date = $date ?? new DateTime();
    }

    public function date(): DateTime
    {
        return $this->date;
    }

    public function value(): string
    {
        return Utils::dateToString($this->date());
    }
}
