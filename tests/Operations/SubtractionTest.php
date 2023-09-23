<?php

namespace CalculatorViaContainer\Tests\Operations;

use CalculatorViaContainer\Operations\Subtraction;
use CalculatorViaContainer\Validators\Validator;
use PHPUnit\Framework\TestCase;

class SubtractionTest extends TestCase
{
    private const MAX_PRECISION = 0.000000001;

    private Subtraction $subtraction;

    protected function setUp(): void
    {
        $validatorStub = $this->createStub(Validator::class);
        $this->subtraction = new Subtraction($validatorStub);
    }

    /** @test */
    public function it_can_process_one_argument()
    {
        $this->assertSame(2, $this->subtraction->calculate(2));
    }

    /** @test */
    public function it_can_process_two_arguments()
    {
        $this->assertSame(38, $this->subtraction->calculate(40, 2));
    }

    /** @test */
    public function it_can_process_multiple_arguments()
    {
        $this->assertSame(52, $this->subtraction->calculate(58, 3, 2, 1));
    }

    /** @test */
    public function it_can_process_a_zero_number()
    {
        $this->assertSame(42, $this->subtraction->calculate(42, 0));
    }

    /** @test */
    public function it_can_process_a_negative_number()
    {
        $this->assertSame(48, $this->subtraction->calculate(45, -3));
    }

    /**
     * @test
     * @dataProvider provideDifferentValues
     */
    public function it_can_perform_subtraction(array $values, $expected)
    {
        $this->assertEqualsWithDelta($expected, $this->subtraction->calculate(...$values), self::MAX_PRECISION);
    }

    public function provideDifferentValues(): array
    {
        return [
            'subtract integer from integer' => [
                [12, 20],
                -8,
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
