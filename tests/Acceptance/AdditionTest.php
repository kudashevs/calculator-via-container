<?php

namespace CalculatorViaContainer\Tests\Acceptance;

use CalculatorViaContainer\Calculator;
use PHPUnit\Framework\TestCase;

class AdditionTest extends TestCase
{
    private const MAX_PRECISION = 0.000000001;

    private Calculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    /**
     * @test
     * @dataProvider provideDifferentIntegerValues
     */
    public function it_can_perform_addition_of_integers(array $values, $expected)
    {
        $this->assertSame($expected, $this->calculator->addition(...$values));
    }

    public function provideDifferentIntegerValues(): array
    {
        return [
            'process an integer zero' => [
                [42, 0],
                42,
            ],
            'process one argument' => [
                [2],
                2,
            ],
            'process two arguments' => [
                [40, 2],
                42,
            ],
            'process multiple arguments' => [
                [58, 3, 2, 1],
                64,
            ],
            'process a negative number' => [
                [45, -3],
                42,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider provideDifferentFloatValues
     */
    public function it_can_perform_addition_of_floats(array $values, $expected)
    {
        $this->assertEqualsWithDelta($expected, $this->calculator->addition(...$values), self::MAX_PRECISION);;
    }

    public function provideDifferentFloatValues(): array
    {
        return [
            'process a float zero' => [
                [12, 0.0],
                12.0,
            ],
            'process one argument' => [
                [2.0],
                2.0,
            ],
            'process two arguments' => [
                [40, 2.0],
                42.0,
            ],
            'process multiple arguments' => [
                [58, 3, 2, 1.0],
                64.0,
            ],
            'process a negative number' => [
                [45, -3],
                42.0,
            ],
            'add float to float' => [
                [0.5, 2.45],
                2.95,
            ],
            'add integer to float' => [
                [12.5, 5],
                17.5,
            ],
            'add float to integer' => [
                [5, 12.5],
                17.5,
            ],
        ];
    }
}
