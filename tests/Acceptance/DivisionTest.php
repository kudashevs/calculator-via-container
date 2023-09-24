<?php

namespace CalculatorViaContainer\Tests\Acceptance;

use CalculatorViaContainer\Calculator;
use CalculatorViaContainer\Exceptions\InvalidOperationArgument;
use CalculatorViaContainer\Operations\Division;
use CalculatorViaContainer\Validators\DivisionValidator;
use PHPUnit\Framework\TestCase;

class DivisionTest extends TestCase
{
    private const MAX_PRECISION = 0.000000001;

    private Calculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    /** @test */
    public function it_can_throw_an_exception_when_division_by_an_integer_zero()
    {
        $this->expectException(InvalidOperationArgument::class);
        $this->expectExceptionMessage('divide by');

        $validator = new DivisionValidator();
        $division = new Division($validator);
        $division->calculate(42, 2, 0);
    }

    /** @test */
    public function it_can_throw_an_exception_when_division_by_a_float_zero()
    {
        $this->expectException(InvalidOperationArgument::class);
        $this->expectExceptionMessage('divide by');

        $validator = new DivisionValidator();
        $division = new Division($validator);
        $division->calculate(42, 2.0, 0.0);
    }

    /**
     * @test
     * @dataProvider provideDifferentIntegerValues
     */
    public function it_can_perform_division_of_integers(array $values, $expected)
    {
        $this->assertSame($expected, $this->calculator->division(...$values));
    }

    public function provideDifferentIntegerValues(): array
    {
        return [
            'process one argument' => [
                [2],
                2,
            ],
            'process two arguments' => [
                [40, 2],
                20,
            ],
            'process multiple arguments' => [
                [58, 4, 2, 1],
                7.25,
            ],
            'process a negative number' => [
                [45, -3],
                -15,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider provideDifferentFloatValues
     */
    public function it_can_perform_division_of_floats(array $values, $expected)
    {
        $this->assertEqualsWithDelta($expected, $this->calculator->division(...$values), self::MAX_PRECISION);
    }

    public function provideDifferentFloatValues(): array
    {
        return [
            'process one argument' => [
                [2.0],
                2.0,
            ],
            'process two arguments' => [
                [40, 2.0],
                20.0,
            ],
            'process multiple arguments' => [
                [58, 4, 2, 1.0],
                7.25,
            ],
            'process a negative number' => [
                [45, -3.0],
                -15.0,
            ],
            'divide float and float' => [
                [3.5, 1.75],
                2.0,
            ],
            'divide integer and float' => [
                [12.5, 5],
                2.5,
            ],
            'divide float and integer' => [
                [5, 12.5],
                0.4,
            ],
        ];
    }
}
