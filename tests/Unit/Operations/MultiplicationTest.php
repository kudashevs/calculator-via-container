<?php

namespace CalculatorViaContainer\Tests\Unit\Operations;

use CalculatorViaContainer\Operations\Multiplication;
use CalculatorViaContainer\Validators\Validator;
use PHPUnit\Framework\TestCase;

class MultiplicationTest extends TestCase
{
    private const MAX_PRECISION = 0.000000001;

    private Multiplication $multiplication;

    protected function setUp(): void
    {
        $validatorStub = $this->createStub(Validator::class);
        $this->multiplication = new Multiplication($validatorStub);
    }

    /** @test */
    public function it_can_process_one_argument()
    {
        $this->assertSame(2, $this->multiplication->calculate(2));
    }

    /** @test */
    public function it_can_process_two_arguments()
    {
        $this->assertSame(80, $this->multiplication->calculate(40, 2));
    }

    /** @test */
    public function it_can_process_multiple_arguments()
    {
        $this->assertSame(464, $this->multiplication->calculate(58, 4, 2, 1));
    }

    /** @test */
    public function it_can_process_a_zero_number()
    {
        $this->assertSame(0, $this->multiplication->calculate(42, 0));
    }

    /** @test */
    public function it_can_process_a_negative_number()
    {
        $this->assertSame(-135, $this->multiplication->calculate(45, -3));
    }

    /**
     * @test
     * @dataProvider provideDifferentValues
     */
    public function it_can_perform_multiplication(array $values, $expected)
    {
        $this->assertEqualsWithDelta($expected, $this->multiplication->calculate(...$values), self::MAX_PRECISION);
    }

    public function provideDifferentValues(): array
    {
        return [
            'multiply integer and integer' => [
                [12, 2],
                24,
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
