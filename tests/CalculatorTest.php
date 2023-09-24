<?php

namespace CalculatorViaContainer\Tests;

use CalculatorViaContainer\Calculator;
use CalculatorViaContainer\Exceptions\InvalidOperationArgument;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    private Calculator $calculator;

    public function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    /** @test */
    public function it_can_throw_an_exception_when_no_arguments_are_provided()
    {
        $this->expectException(InvalidOperationArgument::class);
        $this->expectExceptionMessage('at least');

        $this->calculator->add();
    }

    /** @test */
    public function it_can_throw_an_exception_when_a_wrong_type_argument_is_provided_to_the_closure()
    {
        $this->expectException(InvalidOperationArgument::class);
        $this->expectExceptionMessage('numeric');

        $this->calculator->add(42, 'wrong');
    }

    /**
     * @test
     * @dataProvider provideDifferentOperations
     */
    public function it_can_perform_an_operation(string $operation, $expected, array $data)
    {
        $result = $this->calculator->$operation(...$data);

        $this->assertSame($expected, $result);
    }

    public function provideDifferentOperations(): array
    {
        return [
            'addition through add' => ['add', 4, [2, 2]],
            'addition through addition' => ['addition', 4, [2, 2]],
            'subtraction through sub' => ['sub', 2, [4, 2]],
            'subtraction through subtraction' => ['subtraction', 2, [4, 2]],
            'multiplication through mult' => ['mult', 4, [2, 2]],
            'multiplication through multiply' => ['multiply', 4, [2, 2]],
            'multiplication through multiplication' => ['multiplication', 4, [2, 2]],
            'division through div' => ['div', 2, [4, 2]],
            'division through divide' => ['divide', 2, [4, 2]],
            'division through division' => ['division', 2, [4, 2]],
        ];
    }
}
