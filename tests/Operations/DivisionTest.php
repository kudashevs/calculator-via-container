<?php

namespace CalculatorViaContainer\Tests\Operations;

use CalculatorViaContainer\Exceptions\InvalidOperationArgument;
use CalculatorViaContainer\Operations\Division;
use CalculatorViaContainer\Validators\Validator;
use PHPUnit\Framework\TestCase;

class DivisionTest extends TestCase
{
    private const MAX_PRECISION = 0.000000001;

    private Division $division;

    protected function setUp(): void
    {
        $validatorStub = $this->createStub(Validator::class);
        $this->division = new Division($validatorStub);
    }

    /** @test */
    public function it_can_throw_an_exception_when_division_by_an_integer_zero()
    {
        $this->expectException(InvalidOperationArgument::class);
        $this->expectExceptionMessage('divide by');

        $validatorMock = $this->createValidatorWithException(
            new InvalidOperationArgument('divide by zero attempt')
        );

        $division = new Division($validatorMock);
        $division->calculate(42, 2, 0);
    }

    /** @test */
    public function it_can_throw_an_exception_when_division_by_a_float_zero()
    {
        $this->expectException(InvalidOperationArgument::class);
        $this->expectExceptionMessage('divide by');

        $validatorMock = $this->createValidatorWithException(
            new InvalidOperationArgument('divide by zero attempt')
        );

        $division = new Division($validatorMock);
        $division->calculate(42, 2.0, 0.0);
    }

    /** @test */
    public function it_can_process_one_argument()
    {
        $this->assertSame(2, $this->division->calculate(2));
    }

    /** @test */
    public function it_can_process_two_arguments()
    {
        $this->assertSame(20, $this->division->calculate(40, 2));
    }

    /** @test */
    public function it_can_process_multiple_arguments()
    {
        $this->assertSame(7.25, $this->division->calculate(58, 4, 2, 1));
    }

    /** @test */
    public function it_can_process_a_negative_number()
    {
        $this->assertSame(-15, $this->division->calculate(45, -3));
    }

    /**
     * @test
     * @dataProvider provideDifferentValues
     */
    public function it_can_perform_division(array $values, $expected)
    {
        $this->assertEqualsWithDelta($expected, $this->division->calculate(...$values), self::MAX_PRECISION);
    }

    public function provideDifferentValues(): array
    {
        return [
            'divide integer and integer' => [
                [42, 20],
                2.1,
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

    private function createValidatorWithException($exception): Validator
    {
        $validatorMock = $this->createMock(Validator::class);
        $validatorMock->expects($this->once())
            ->method('validate')
            ->willThrowException($exception);

        return $validatorMock;
    }
}
