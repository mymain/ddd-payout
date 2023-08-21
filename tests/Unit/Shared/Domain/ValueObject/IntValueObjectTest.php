<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObject;

use Payouts\Shared\Domain\ValueObject\IntValueObject;
use PHPUnit\Framework\TestCase;

final class IntValueObjectTest extends TestCase
{
    private IntValueObject $object;

    /**
     * @dataProvider graterThanTestDataProvider
     */
    public function testGraterThan(int $amount, bool $graterThan): void
    {
        $this->object = new IntValueObject(100);

        $this->assertEquals($graterThan, $this->object->greaterThan(new IntValueObject($amount)));
    }

    public function graterThanTestDataProvider(): array
    {
        return [
            [99, true],
            [100, false],
        ];
    }

    /**
     * @dataProvider lessThanTestDataProvider
     */
    public function testLessThan(int $amount, bool $lessThan): void
    {
        $this->object = new IntValueObject(100);

        $this->assertEquals($lessThan, $this->object->lessThan(new IntValueObject($amount)));
    }

    public function lessThanTestDataProvider(): array
    {
        return [
            [100, false],
            [101, true],
        ];
    }
}
