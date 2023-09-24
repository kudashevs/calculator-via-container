<?php

namespace CalculatorViaContainer\Tests\Acceptance;

use CalculatorViaContainer\Calculator;
use PHPUnit\Framework\TestCase;

class SubtractionTest extends TestCase
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
    public function it_can_perform_subtraction_of_integers(array $values, $expected)
    {
        $this->assertSame($expected, $this->calculator->subtraction(...$values));
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
                38,
            ],
            'process multiple arguments' => [
                [58, 3, 2, 1],
                52,
            ],
            'process a negative number' => [
                [45, -3],
                48,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider provideDifferentFloatValues
     */
    public function it_can_perform_subtraction_of_floats(array $values, $expected)
    {
        $this->assertEqualsWithDelta($expected, $this->calculator->subtraction(...$values), self::MAX_PRECISION);
    }

    public function provideDifferentFloatValues(): array
    {
        return [
            'process a float zero' => [
                [42, 0.0],
                42.0,
            ],
            'process one argument' => [
                [2.0],
                2.0,
            ],
            'process two arguments' => [
                [40, 2.0],
                38.0,
            ],
            'process multiple arguments' => [
                [58, 3, 2, 1.0],
                52.0,
            ],
            'process a negative number' => [
                [45, -3.0],
                48.0,
            ],
            'subtract float from float' => [
                [2.5, 2.45],
                0.05,
            ],
            'subtract integer from float' => [
                [12.5, 5],
                7.5,
            ],
            'subtract float from integer' => [
                [5, 1.25],
                3.75,
            ],
        ];
    }
}
