<?php

namespace CalculatorViaContainer\Tests\Unit\Validators;

use CalculatorViaContainer\Exceptions\InvalidOperationArgument;
use CalculatorViaContainer\Validators\DefaultValidator;
use PHPUnit\Framework\TestCase;

class DefaultValidatorTest extends TestCase
{
    private DefaultValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new DefaultValidator();
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
}
