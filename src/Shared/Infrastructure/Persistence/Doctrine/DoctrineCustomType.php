<?php

declare(strict_types=1);

namespace Payouts\Shared\Infrastructure\Persistence\Doctrine;

interface DoctrineCustomType
{
    public static function customTypeName(): string;
}
