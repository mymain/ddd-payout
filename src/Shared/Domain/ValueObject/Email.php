<?php

declare(strict_types=1);

namespace Payouts\Shared\Domain\ValueObject;

use Webmozart\Assert\Assert;

class Email
{
    public function __construct(protected readonly string $email)
    {
        Assert::email($this->email);
    }

    public function value(): string
    {
        return $this->email;
    }
}
