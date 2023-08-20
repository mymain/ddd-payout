<?php

declare(strict_types=1);

namespace Payouts\Shared\Infrastructure\Persistence\Doctrine;

use Payouts\Shared\Domain\Utils;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

abstract class UuidType extends StringType implements DoctrineCustomType
{
    abstract protected function typeClassName(): string;

    public function getName(): string
    {
        return self::customTypeName();
    }

    public static function customTypeName(): string
    {
        $nameSpace = explode('\\', static::class);

        return Utils::toSnakeCase(str_replace('Type', '', end($nameSpace)));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        $className = $this->typeClassName();

        return new $className($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value->value();
    }
}
