<?php

namespace CalculatorViaContainer\Tests\Unit\Operations;

use CalculatorViaContainer\Exceptions\InvalidOperationArgument;
use CalculatorViaContainer\Operations\Operation;
use CalculatorViaContainer\Validators\DefaultValidator;
use PHPUnit\Framework\TestCase;

class OperationTest extends TestCase
{
    private Operation $operation;

    protected function setUp(): void
    {
        $this->operation = $this->createOperation();
    }

    /** @test */
    public function it_can_throw_an_exception_when_no_arguments_provided()
    {
        $this->expectException(InvalidOperationArgument::class);
        $this->expectExceptionMessage('at least');

        $this->operation->calculate();
    }

    /** @test */
    public function it_can_throw_an_exception_when_an_argument_of_a_wrong_type()
    {
        $this->expectException(InvalidOperationArgument::class);
        $this->expectExceptionMessage('numeric');

        $this->operation->calculate(42, 'wrong');
    }

    private function createOperation(): Operation
    {
        $validator = new DefaultValidator();

        return new class($validator) extends Operation {
            protected function performCalculation(...$arguments)
            {
                throw new \LogicException('The method is not supposed to be used in this test.');
            }
        };
    }
}
