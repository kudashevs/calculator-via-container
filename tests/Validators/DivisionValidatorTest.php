<?php

namespace CalculatorViaContainer\Tests\Validators;

use CalculatorViaContainer\Exceptions\InvalidOperationArgument;
use CalculatorViaContainer\Validators\DivisionValidator;
use PHPUnit\Framework\TestCase;

class DivisionValidatorTest extends TestCase
{
    private DivisionValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new DivisionValidator();
    }

    /** @test */
    public function it_can_throw_an_exception_when_no_arguments_provided()
    {
        $this->expectException(InvalidOperationArgument::class);
        $this->expectExceptionMessage('at least');

        $this->validator->validate();
    }

    /** @test */
    public function it_can_throw_an_exception_when_an_argument_of_a_wrong_type()
    {
        $this->expectException(InvalidOperationArgument::class);
        $this->expectExceptionMessage('numeric');

        $this->validator->validate(42, 'wrong');
    }

    /** @test */
    public function it_can_throw_an_exception_when_division_by_an_integer_zero()
    {
        $this->expectException(InvalidOperationArgument::class);
        $this->expectExceptionMessage('divide by');

        $this->validator->validate(42, 0);
    }

    /** @test */
    public function it_can_throw_an_exception_when_division_by_a_float_zero()
    {
        $this->expectException(InvalidOperationArgument::class);
        $this->expectExceptionMessage('divide by');

        $this->validator->validate(42, 0.0);
    }
}
