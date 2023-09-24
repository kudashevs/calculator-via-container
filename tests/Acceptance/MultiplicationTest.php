<?php

namespace CalculatorViaContainer\Tests\Acceptance;

use CalculatorViaContainer\Calculator;
use PHPUnit\Framework\TestCase;

class MultiplicationTest extends TestCase
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
    public function it_can_perform_multiplication_of_integers(array $values, $expected)
    {
        $this->assertSame($expected, $this->calculator->multiplication(...$values));
    }

    public function provideDifferentIntegerValues(): array
    {
        return [
            'process an integer zero' => [
                [42, 0],
                0,
            ],
            'process one argument' => [
                [2],
                2,
            ],
            'process two arguments' => [
                [40, 2],
                80,
            ],
            'process multiple arguments' => [
                [58, 4, 2, 1],
                464,
            ],
            'process a negative number' => [
                [45, -3],
                -135,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider provideDifferentFloatValues
     */
    public function it_can_perform_multiplication_of_floats(array $values, $expected)
    {
        $this->assertEqualsWithDelta($expected, $this->calculator->multiplication(...$values), self::MAX_PRECISION);
    }

    public function provideDifferentFloatValues(): array
    {
        return [
            'process a float zero' => [
                [42, 0.0],
                0.0,
            ],
            'process one argument' => [
                [2.0],
                2.0,
            ],
            'process two arguments' => [
                [40, 2.0],
                80.0,
            ],
            'process multiple arguments' => [
                [58, 4, 2, 1.0],
                464.0,
            ],
            'process a negative number' => [
                [45, -3.0],
                -135.0,
            ],
            'multiply float and float' => [
                [2.5, 1.45],
                3.625,
            ],
            'multiply integer and float' => [
                [5, 12.5],
                62.5,
            ],
            'multiply float and integer' => [
                [12.5, 5],
                62.5,
            ],
        ];
    }
}
